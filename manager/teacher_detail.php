<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}
include "../connection.php";

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
    <h2 class="profile">Thông tin</h2>

    <?php

    $user_ID = isset($_GET['id']) ? $_GET['id'] : die('ID không được cung cấp.');
    // Truy vấn lấy thông tin chi tiết của giáo viên
    $query = "SELECT * FROM User_General WHERE user_ID = $user_ID";
    $result = $conn->query($query);

    // Kiểm tra xem giáo viên có tồn tại không
    if ($result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
        // Hiển thị thông tin chi tiết của giáo viên
        echo '<div class="teacher-detail">';
        if (!empty($teacher['teacher_image'])) {
            echo '<img style=" width: 150px" src="../image/' . $teacher['teacher_image'] . '" alt="Ảnh giáo viên">';
        } else {
            echo 'Không có hình ảnh.';
        }
        echo '<p>Họ tên: ' . $teacher['FullName'] . '</p>';
        echo '<p>Email: ' . $teacher['user_Email'] . '</p>';
        echo '<p>Số Điện Thoại: ' . $teacher['PhoneNumber'] . '</p>';
        echo '<p>Địa chỉ: ' . $teacher['teacher_Address'] . '</p>';
        echo '<p>Ngày sinh: ' . date('d-m-Y', strtotime($teacher['teacher_birthday'])) . '</p>';
        echo '<p>Giới tính: ' . $teacher['teacher_gender'] . '</p>';
        echo '<p>Dân tộc: ' . $teacher['teacher_nationality'] . '</p>';
        echo '<p>Chuyên môn: ' . $teacher['teacher_Specialization'] . '</p>';
        echo '<p>Trình Độ: ' . $teacher['teacher_Qualification'] . '</p>';
        echo '<p>Kinh Nghiệm Giảng Dạy: ' . $teacher['teacher_experience'] . '</p>';
        echo '<span class="close-btn" onclick="closeDetails()"><i class="fa-solid fa-xmark"></i></span>';
        echo '</div>';
    } else {
        echo "Không tìm thấy thông tin giáo viên.";
    }
    ?>

    <script>
        function closeDetails() {
            document.querySelector('.teacher-details').style.display = 'none';
        }
    </script>
</body>

</html>