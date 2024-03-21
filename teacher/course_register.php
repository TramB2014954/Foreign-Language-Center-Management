<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}

include '../connection.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['course_id'])) {
        $courseId = $_POST['course_id'];
        $teacherEmail = $_SESSION['email'];

        // Check if the teacher is already registered for the course with status 'approved' or 'pending'
        $checkRegistrationQuery = "SELECT * FROM Teacher_Registration WHERE user_ID = (SELECT user_ID FROM User_General WHERE user_Email = '$teacherEmail') AND course_ID = '$courseId' AND status IN ('approved', 'pending')";
        $checkRegistrationResult = mysqli_query($conn, $checkRegistrationQuery);


        if ($checkRegistrationResult && mysqli_num_rows($checkRegistrationResult) > 0) {
            // Student is already registered
            echo "<script>alert('Bạn đã đăng ký khóa học này rồi.');</script>";
            echo "<script>window.location = 'course_detail.php?course_id=$courseId';</script>";
        } else {

            // Retrieve start date and end date from the database
            $courseInfoQuery = "SELECT StartDate, EndDate FROM Course WHERE course_ID = '$courseId'";
            $courseInfoResult = mysqli_query($conn, $courseInfoQuery);

            if ($courseInfoResult && mysqli_num_rows($courseInfoResult) > 0) {
                $courseInfo = mysqli_fetch_assoc($courseInfoResult);
                $startDate = $courseInfo['StartDate'];
                $endDate = $courseInfo['EndDate'];

                // Check for time conflicts
                $timeConflictQuery = "SELECT C.StartDate, C.EndDate FROM Teacher_Registration TR
                                JOIN Course C ON TR.course_ID = C.course_ID
                                WHERE TR.user_ID = (SELECT user_ID FROM User_General WHERE user_Email = '$teacherEmail') 
                                    AND TR.status IN ('approved', 'pending')
                                    AND (
                                        (C.StartDate >= '$startDate' AND C.StartDate <= '$endDate')
                                        OR (C.EndDate >= '$startDate' AND C.EndDate <= '$endDate')
                                        OR ('$startDate' >= C.StartDate AND '$startDate' <= C.EndDate)
                                        OR ('$endDate' >= C.StartDate AND '$endDate' <= C.EndDate)
                                    )";
                //echo $timeConflictQuery;
                $timeConflictResult = mysqli_query($conn, $timeConflictQuery);

                if ($timeConflictResult && mysqli_num_rows($timeConflictResult) > 0) {
                    // echo "<script>alert('Không thể đăng ký vì có xung đột thời gian với các khóa học đã đăng ký');</script>";
                    // echo "<script>window.location = 'course_detail.php?course_id=$courseId';</script>";
                    $getthu = "SELECT day_id FROM Class_Day WHERE course_ID = '$courseId'";
                    $getthuResult = mysqli_query($conn, $getthu);
                    $thu = mysqli_fetch_assoc($getthuResult);
                    if ($thu['day_id'][0] == 3) {
                        $thu0 = 3;
                        $thu1 = 5;
                        $thu2 = 7;
                    } else {
                        $thu0 = 2;
                        $thu1 = 4;
                        $thu2 = 6;
                    }

                    $checkthu = "SELECT c.course_id, cd.day_id, t.user_id from teacher_registration t
                                join course c on c.course_id = t.course_id
                                join class_day cd on c.course_id = cd.course_id
                                WHERE t.user_ID = (SELECT user_ID FROM User_General WHERE user_Email = '$teacherEmail') 
                                and (cd.day_id = $thu0 or cd.day_id = $thu1 or cd.day_id = $thu2)";
                    $checkthuResult = mysqli_query($conn, $checkthu);
                    if ($checkthuResult && mysqli_num_rows($checkthuResult) > 0) {
                        $getca = "(SELECT class_id from Course where course_id = $courseId)";
                        $checkca = "SELECT c.course_id, cs.Class_id, cs.class_Time, t.user_id from teacher_registration t
                                    join course c on c.course_id = t.course_id
                                    join class_session cs on c.class_id = cs.class_id
                                    where  t.user_ID = (SELECT user_ID FROM User_General WHERE user_Email = '$teacherEmail') and cs.class_id = $getca ";
                        $checkcaResult = mysqli_query($conn, $checkca);
                        if ($checkcaResult && mysqli_num_rows($checkcaResult) > 0) {
                            echo "<script>alert('Bạn không thể đăng kí dạy khóa học này do xung đột thời gian!');</script>";
                            echo "<script>window.location = 'course_detail.php?course_id=$courseId';</script>";
                        } else {
                            $registrationDate = date('Y-m-d H:i:s');
                            $insertRegistrationQuery = "INSERT INTO Teacher_Registration (user_ID, course_ID, registration_date) VALUES ((SELECT user_ID FROM User_General WHERE user_Email = '$teacherEmail'), '$courseId', '$registrationDate')";

                            if (mysqli_query($conn, $insertRegistrationQuery)) {
                                echo "<script>alert('Bạn đã đăng ký thành công! Chờ duyệt');</script>";
                                echo "<script>window.location = 'course_detail.php?course_id=$courseId';</script>";
                            } else {
                                echo "<script>alert('Có lỗi khi thêm vào database');</script>";
                                echo "Lỗi khi thêm vào database: " . mysqli_error($conn);
                            }
                        }
                    } else {
                        $registrationDate = date('Y-m-d H:i:s');
                        $insertRegistrationQuery = "INSERT INTO Teacher_Registration (user_ID, course_ID, registration_date) VALUES ((SELECT user_ID FROM User_General WHERE user_Email = '$teacherEmail'), '$courseId', '$registrationDate')";

                        if (mysqli_query($conn, $insertRegistrationQuery)) {
                            echo "<script>alert('Bạn đã đăng ký thành công! Chờ duyệt');</script>";
                            echo "<script>window.location = 'course_detail.php?course_id=$courseId';</script>";
                        } else {
                            echo "<script>alert('Có lỗi khi thêm vào database');</script>";
                            echo "Lỗi khi thêm vào database: " . mysqli_error($conn);
                        }
                    }
                } else {
                    $registrationDate = date('Y-m-d H:i:s');
                    $insertRegistrationQuery = "INSERT INTO Teacher_Registration (user_ID, course_ID, registration_date) VALUES ((SELECT user_ID FROM User_General WHERE user_Email = '$teacherEmail'), '$courseId', '$registrationDate')";

                    if (mysqli_query($conn, $insertRegistrationQuery)) {
                        echo "<script>alert('Bạn đã đăng ký thành công! Chờ duyệt');</script>";
                        echo "<script>window.location = 'course_detail.php?course_id=$courseId';</script>";
                    } else {
                        echo "<script>alert('Có lỗi khi thêm vào database');</script>";
                        echo "Lỗi khi thêm vào database: " . mysqli_error($conn);
                    }
                }
            } else {
                echo "<script>alert('Không thể lấy thông tin khóa học');</script>";
            }
        }
    } else {
        echo "<script>alert('Dữ liệu không hợp lệ');</script>";
    }
}
