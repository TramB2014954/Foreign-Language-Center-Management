<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}

include "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và kiểm tra tính hợp lệ
    $courseName = mysqli_real_escape_string($conn, $_POST['courseName']);
    $courseType = mysqli_real_escape_string($conn, $_POST['courseType']);
    $className = mysqli_real_escape_string($conn, $_POST['className']);
    $courseFee = mysqli_real_escape_string($conn, $_POST['courseFee']);
    $totalSlots = mysqli_real_escape_string($conn, $_POST['totalSlots']);
    $startDate = mysqli_real_escape_string($conn, $_POST['startDate']);
    $endDate = mysqli_real_escape_string($conn, $_POST['endDate']);
    $classDays = $_POST['dayOfWeek'];
    $classTime = mysqli_real_escape_string($conn, $_POST['classTime']);

    // Kiểm tra tính hợp lệ của dữ liệu
    if (empty($courseName) || empty($courseType) || empty($className) || empty($courseFee) || empty($totalSlots) || empty($startDate) || empty($endDate) || empty($classDays) || empty($classTime)) {
        echo "Vui lòng điền đầy đủ thông tin.";
    } else {
        // Kiểm tra xem Class_Name có bị trùng không
        $checkDuplicateQuery = $conn->prepare("SELECT COUNT(*) as count FROM Course WHERE Class_Name = ?");
        $checkDuplicateQuery->bind_param("s", $className);
        $checkDuplicateQuery->execute();
        $checkDuplicateResult = $checkDuplicateQuery->get_result();
        $row = $checkDuplicateResult->fetch_assoc();
        $count = $row['count'];
        $checkDuplicateQuery->close();

        $errorMessage = "";

        if ($count > 0) {
            echo "<script>alert('Tên khóa học bị trùng!');</script>";
            echo "<script>window.location = 'insert_course.php';</script>";
        } else {
            // Thực hiện truy vấn SQL để thêm thông tin khóa học vào bảng Course sử dụng Prepared Statements
            $insertCourseQuery = $conn->prepare("INSERT INTO Course (course_Name, Class_Name, course_Fee, course_TotalSlot, course_AvailableSlot, StartDate, EndDate, TC_ID, Class_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $courseFee = floatval(str_replace(',', '', $courseFee));

            $insertCourseQuery->bind_param("ssdiissss", $courseName, $className, $courseFee, $totalSlots, $totalSlots, $startDate, $endDate, $courseType, $classTime);
            $insertCourseQuery->execute();

            $courseID = $insertCourseQuery->insert_id;
            $insertCourseQuery->close();

            // Thêm thông tin ngày học vào bảng Class_Day
            foreach ($classDays as $day) {
                $insertClassDayQuery = $conn->prepare("INSERT INTO Class_Day (course_ID, Day_ID) VALUES (?, ?)");
                $insertClassDayQuery->bind_param("ii", $courseID, $day);
                $insertClassDayQuery->execute();
                $insertClassDayQuery->close();
            }

            $_SESSION['success'] = true;
            header("Location: m_homepage.php?success=1");
        }
    }
}
