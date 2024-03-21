<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}
include "../connection.php";

// Kiểm tra xem có tham số id được truyền vào không

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .teacher-details {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: fit-content;
            border-radius: 5px;
        }

        .profile {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_GET['id'])) {
        $teacherId = $_GET['id'];

        // Truy vấn lấy thông tin các lớp giảng dạy của giáo viên có id tương ứng
        $query = "
        SELECT TR.course_ID, C.course_name, C.Class_Name
        FROM Teacher_Registration TR
        JOIN Course C ON TR.course_ID = C.course_ID
        WHERE TR.user_ID = $teacherId AND TR.status = 'approved'
    ";

        $result = $conn->query($query);

        // Kiểm tra và hiển thị danh sách lớp
        if ($result->num_rows > 0) {
            echo '<h4>Danh sách lớp giảng dạy:</h4>';
            echo '<ul>';
            while ($row = $result->fetch_assoc()) {
                echo '<li>' . $row['course_name'] . ' - Lớp: ' . $row['Class_Name'] . '</li>';
            }
            echo '</ul>';
        } else {
            echo 'Giáo viên này không giảng dạy lớp nào.';
        }
    } else {
        echo 'Không có thông tin giáo viên.';
    }
    ?>
</body>

</html>