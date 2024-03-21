<?php
session_start();

date_default_timezone_set('Asia/Ho_Chi_Minh');


if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include '../connection.php';

// Kiểm tra xem có tham số truyền vào không
if (isset($_GET['course_id']) && !empty($_GET['course_id'])) {
    $courseId = $_GET['course_id'];


    $sql = "SELECT * FROM Course
    INNER JOIN Teacher_Registration ON Teacher_Registration.course_ID = Course.course_ID
    INNER JOIN User_General ON Teacher_Registration.user_ID = User_General.user_ID
    WHERE Teacher_Registration.course_ID = '$courseId' AND Teacher_Registration.status = 'approved'";
    $result = mysqli_query($conn, $sql);

    // Lấy thông tin khóa học từ CSDL
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $courseName = $row['course_Name'];
        $courseFee = number_format($row['course_Fee']) . ' VND';
        $totalSlots = $row['course_TotalSlot'];
        $availableSlots = $row['course_AvailableSlot'];
        $startDate = $row['StartDate'];
        $endDate = $row['EndDate'];
        $teacherName = $row['FullName'];

        //lấy ca học
        $classID = $row['Class_ID'];
        $classTimesql = "SELECT * from Class_Session where Class_ID='$classID'";
        $classTimeResult = mysqli_query($conn, $classTimesql);
        if ($classTimeResult && mysqli_num_rows($classTimeResult) > 0) {
            $classTimeRow = mysqli_fetch_assoc($classTimeResult);
            $classTime = $classTimeRow['Class_Time'];
        }


        // Lấy thông tin loại khóa học từ CSDL bằng cách sử dụng khóa ngoại TC_ID
        $tcId = $row['TC_ID'];
        $tcSql = "SELECT * FROM Type_Course WHERE TC_ID = '$tcId'";
        $tcResult = mysqli_query($conn, $tcSql);
        if ($tcResult && mysqli_num_rows($tcResult) > 0) {
            $tcRow = mysqli_fetch_assoc($tcResult);
            $combo = $tcRow['TC_Combo'];
            $target = $tcRow['TC_Target'];
            $information = $tcRow['TC_Information'];
        } else {
            // Không tìm thấy thông tin khóa học
            header("Location: error_page.php");
            exit();
        }
    } else {
        // Không tìm thấy thông tin khóa học
        header("Location: error_page.php");
        exit();
    }
} else {
    // Không có ID khóa học được truyền vào
    header("Location: error_page.php");
    exit();
}

//Lấy ca học
$classSql = "SELECT * FROM Class_Day WHERE course_ID = '$courseId'";
$classResult = mysqli_query($conn, $classSql);
$classSchedule = [];

if ($classResult && mysqli_num_rows($classResult) > 0) {
    while ($classRow = mysqli_fetch_assoc($classResult)) {
        $classDay = $classRow['Day_ID'];
        $classSchedule[] = "$classDay";
    }
}

$combo = explode('|', $combo);
$targets = explode('|', $target);
$information = explode('|', $information);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Khóa Học</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .course-details {
            margin-top: 50px;
        }

        .course-title {
            color: #007bff;
        }

        .course-info {
            margin-top: 20px;
        }

        .course-info .col-md-12 {
            background-color: white;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .course-info .col-md-2 {
            background-color: white;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.1);
        }

        strong {
            font-size: large;
            color: #0056b3;
        }

        .title_small {
            font-weight: 500;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            justify-content: center;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* CSS cho form xác nhận đăng ký */
        #confirmationForm {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .confirmation-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 50%;
            margin: auto;

        }

        .confirmation-box h3 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #007bff;
        }

        .confirmation-box button {
            background-color: #007bff;
            color: whitesmoke;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 10px;
        }

        .confirmation-box button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php include 'header.php' ?>

    <div class="container course-details">
        <!-- Thêm form xác nhận đăng ký và ẩn nó -->
        <div id="confirmationForm">
            <div class="confirmation-box">
                <h3>Xác nhận đăng ký khóa học</h3>
                <form id="registrationForm" action="course_register.php" method="post">
                    <input type="hidden" name="course_id" value="<?php echo $courseId; ?>">
                    <button type="submit" name="confirmSubmit">Xác nhận</button>
                    <button type="button" onclick="cancelConfirmation()">Hủy</button>
                </form>
            </div>
        </div>
        <h2 class="course-title">
            <?php echo $courseName; ?>
        </h2>
        <div class="course-info">
            <div class="row">
                <div class="col-md-10">
                    <div class="col-md-12">
                        <p><strong>Thông tin khóa học</strong><br>

                        <p class="title_small">Chương trình học:</p>
                        <?php foreach ($information as $item) : ?>
                            <div class="item">
                                <p>
                                    <?php echo $item; ?>
                                </p>
                            </div>
                        <?php endforeach; ?>

                        <p class="title_small">Ngày bắt đầu:
                            <?php $startDateFormatted = date('d-m-Y', strtotime($startDate));
                            echo $startDateFormatted; ?>
                        </p>
                        <p class="title_small">Ngày kết thúc:
                            <?php $endDateFormatted = date('d-m-Y', strtotime($endDate));
                            echo $endDateFormatted; ?>
                        </p>


                        <p class="title_small">Các Ca Học: <?php echo $classTime ?></p>
                        <?php foreach ($classSchedule as $class) : ?>
                            <a>

                                <?php echo "Thứ " . $class; ?>
                            </a>
                        <?php endforeach; ?>
                        </p>
                    </div>
                    <div class="col-md-12">
                        <p><strong>Combo</strong><br>
                            <?php foreach ($combo as $item) : ?>
                        <div class="item">
                            <p>
                                <?php echo $item; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                    </p>
                    </div>
                    <div class="col-md-12">
                        <p><strong>Bạn sẽ đạt được gì sau khóa học?</strong><br>
                            <?php foreach ($targets as $item) : ?>
                        <div class="item">
                            <p>
                                <?php echo $item; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                    </p>
                    </div>

                </div>
                <div class="col-md-2">
                    <p><strong>Học phí:</strong><br>
                        <?php echo $courseFee; ?>
                    </p>
                    <p><strong>Giáo viên: </strong><br>
                        <?php echo $teacherName ?>
                    </p>
                    <p><strong>Số lượng học viên</strong><br>
                        <?php echo $totalSlots; ?>
                    </p>
                    <p><strong>Chưa đăng kí:</strong><br>
                        <?php echo $availableSlots; ?>
                    </p>

                    <!-- Nút đăng ký khóa học -->
                    <input type="hidden" id="courseId" name="course_id" value="<?php echo $courseId; ?>">
                    <button type="button" onclick="showConfirmationForm()">ĐĂNG KÍ</button>
                    <div id="confirmationForm" style="display:none;">
                        <h3>Xác nhận đăng ký khóa học</h3>
                        <form action="course_register.php" method="post">
                            <input type="hidden" name="course_id" value="<?php echo $courseId; ?>">
                            <button type="submit" name="confirmSubmit">Xác nhận</button>
                            <button type="button" onclick="cancelConfirmation()">Hủy</button>
                        </form>
                    </div>
                    <div id="successMessage" style="display: none;">
                        Đăng ký thành công!
                    </div>
                    <script>
                        function submitRegistration() {
                            var courseId = $("#courseId").val();

                            $.ajax({
                                type: "POST",
                                url: "course_register.php", // Đường dẫn đến tập tin xử lý đăng ký
                                data: {
                                    course_id: courseId
                                },
                                success: function(response) {
                                    // Ẩn form đăng ký và hiển thị thông báo thành công
                                    $("#registrationForm").hide();
                                    $("#successMessage").show();
                                },
                                error: function(error) {
                                    // Xử lý lỗi khi đăng ký không thành công
                                    console.log(error);
                                }
                            });
                        }

                        function cancelConfirmation() {
                            // Ẩn form đăng ký
                            $("#registrationForm").hide();
                        }
                    </script>


                    <script>
                        function showConfirmationForm() {
                            document.getElementById("confirmationForm").style.display = "block";
                        }

                        function cancelConfirmation() {
                            document.getElementById("confirmationForm").style.display = "none";
                        }
                    </script>

                </div>

            </div>
        </div>
    </div>

    <?php include '../aboutus.html' ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>