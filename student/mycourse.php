<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}

include '../connection.php';

$email = $_SESSION['email'];
$sql = "SELECT Course.course_ID, Course.course_Name, Course.course_Fee, Student_Registration.registration_date, User_General.user_Email
        FROM Course
        INNER JOIN Student_Registration ON Course.course_ID = Student_Registration.course_ID
        INNER JOIN User_General ON Student_Registration.user_ID = User_General.user_ID
        WHERE User_General.user_Email = '$email'
        ORDER BY Student_Registration.registration_date;";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #e8f2ff;
        }

        .header {
            background-color: white;
            color: black;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 999;
            box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .right p:first-child {
            padding-right: 20px;
        }

        .left h2 {
            font-family: fantasy;
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .left h2:hover {
            text-decoration: none;
            cursor: pointer;
        }

        .right {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: #35509a;
            font-weight: 500;
        }

        .right a {
            padding-right: 10px;
        }

        .container {
            padding-top: 70px;
            margin-bottom: 175px;
        }

        #courseList .course-card {
            margin-bottom: 30px;
            margin-left: 50px;
        }

        h2 {
            margin-top: 20px;
        }

        .course-card {
            margin-bottom: 30px;
        }

        .card {
            margin: 20px;
            border: none;
            box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-text {
            color: #343a40;
            margin-bottom: 15px;
        }

        .card-body {
            padding: 20px;
        }

        .card a {
            color: #007bff;
            text-decoration: none;
        }

        .card a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Khóa học của tôi</h2>
        <div class="row" id="courseList">

            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['course_Name'] . '</h5>';
                    echo '<p class="card-text">Học Phí: ' . number_format($row['course_Fee']) . ' VND</p>';
                    $registrationDate = strtotime($row['registration_date']);
                    $formattedDate = date('H:i:s d-m-Y', $registrationDate);
                    echo '<p>Thời gian đăng ký: ' . $formattedDate . '</p>';
                    echo '<p><a href="course_detail.php?course_id=' . $row['course_ID'] . '" class="">[Xem chi tiết]</a></p>';
                    echo '<a href="cancel_course.php" class="cancel-registration-btn" data-course-id="' . $row['course_ID'] . '">Hủy Đăng Ký</a>';
                    echo '</div></div>';
                }
            } else {
                echo '<p>Bạn chưa đăng kí khóa học nào!</p>';
            }
            ?>
        </div>
    </div>
    <?php include '../aboutus.html' ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var cancelButtons = document.querySelectorAll('.cancel-registration-btn');

            cancelButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Ngăn chặn sự kiện mặc định của nút
                    var courseId = button.getAttribute('data-course-id');

                    // Sử dụng hộp thoại xác nhận
                    var confirmCancel = confirm("Bạn có chắc chắn muốn hủy đăng ký khóa học này?");
                    if (confirmCancel) {
                        window.location.href = 'cancel_course.php?course_id=' + courseId;
                    }
                });
            });
        });
    </script>
</body>

</html>