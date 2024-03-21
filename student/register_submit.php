<?php
include '../connection.php';
session_start();

if (isset($_POST['submit']) && $_POST["fullname"] != '' && $_POST["email"] != '' && $_POST["phonenumber"] != '' && $_POST["password"] != '' && $_POST["repassword"] != '') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $phonenumber = $_POST['phonenumber'];

    if ($password != $repassword) {
        $passwordError = "Mật khẩu không khớp!";
        $_SESSION['password_error'] = $passwordError;
        header("Location: register.php");
        exit();
    }

    $checkEmailQuery = "SELECT * FROM User_General WHERE user_Email='$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $emailError = "Email đã tồn tại!";
        $_SESSION['email_error'] = $emailError;
        header("Location: register.php?error=invalid");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $insertLoginQuery = "INSERT INTO User_General (user_Email, user_password, FullName, PhoneNumber, role) VALUES ('$email', '$hashedPassword', '$fullname', '$phonenumber', 'student')";
    $insertLoginResult = mysqli_query($conn, $insertLoginQuery);

    if (!$insertLoginResult) {
        header("Location: register.php?error=invalid");
        exit();
    }

    header("Location: ../login/login.php");
    exit();
} else {
    header("Location: register.php");
    exit();
}
