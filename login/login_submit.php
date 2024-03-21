<?php
include '../connection.php';
session_start();

if (isset($_POST['submit']) && $_POST["email"] != '' && $_POST["password"] != '') {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Kiểm tra thông tin người dùng từ bảng User_General
    $sql = "SELECT * FROM User_General WHERE user_Email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['user_password'];

        // Kiểm tra mật khẩu với password_verify()
        if (password_verify($password, $hashedPassword)) {
            // Lưu vai trò của người dùng vào session
            $_SESSION['role'] = $row['role'];
            $_SESSION['email'] = $email;

            // Dựa vào vai trò, chuyển hướng đến trang tương ứng
            if ($_SESSION['role'] == 'student') {
                header("Location: ../student/homepage.php");
            } elseif ($_SESSION['role'] == 'teacher') {
                header("Location: ../teacher/homepage_teacher.php");
            } elseif ($_SESSION['role'] == 'manager') {
                header("Location: ../manager/m_homepage.php");
            }
            exit();
        } else {
            header("Location: login.php?error=invalid");
            exit();
        }
    } else {
        header("Location: login.php?error=invalid");
        exit();
    }
} else {
    header("Location: login.php");
}
