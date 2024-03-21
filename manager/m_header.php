<?php

$teacherEmail = $_SESSION['email'];

if (isset($_SESSION['success']) && $_SESSION['success'] === true) {
    echo '<script>showSuccessModal();</script>';
    // Xóa session 
    var_dump($_SESSION['success']);
    unset($_SESSION['success']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh tiêu đề</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.20.0/font/bootstrap-icons.css" rel="stylesheet">
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

        .left {
            display: flex;
            flex-direction: row;
        }

        .left h2 {
            font-family: fantasy;
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .left a {
            font-family: fantasy;
            color: black;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s ease;

        }

        .left a h2:hover {
            transform: scale(1.05);
            cursor: pointer;
        }


        .center a {
            padding: 20px 50px;
            text-decoration: none;
            background-color: #f8f9fa;
            color: black;
            font-weight: 600;
            font-size: larger;
        }

        .center a:hover {
            background-color: #dee2e6;
        }

        .right {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: #35509a;
            font-weight: 500;
            font-size: 25px;
        }

        .right a {
            padding-right: 10px;
            color: #35509a;
        }

        .right i {
            transition: transform 0.2s ease;
        }

        .right i:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        .container {
            margin-top: 80px;
        }

        h4 {
            margin-bottom: 20px;
        }

        .btn-group {
            margin-bottom: 20px;
        }

        .modal-backdrop.show {
            opacity: 0;
        }

        .modal-content {
            background-color: #ffffff;
            color: #333333;
            border-radius: 10px;
            width: 400px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="left">
            <a href="m_homepage.php" onclick="reloadPage()">
                <h2>LANGMASTER</h2>
            </a>
        </div>
        <div class="center">
            <a href="insert_course.php">Thêm Khóa Học Mới</a>
            <a href="course_approve.php">Duyệt Khóa Học</a>
            <a href="teacher_in4.php">Thông Tin Giáo Viên</a>
        </div>
        <div class="right">
            <i class="fa-solid fa-bell" style="margin-right: 20px;"></i>
            <a href="logout.php" class=""><i class="fa-solid fa-right-from-bracket"></i></a>

        </div>
    </div>
</body>

</html>