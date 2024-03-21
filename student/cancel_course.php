<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}

include '../connection.php';

// Kiểm tra xem 'course_id' có tồn tại trong query parameter không
if (isset($_GET['course_id']) && !empty($_GET['course_id'])) {
    // Lấy course_id từ query parameter
    $courseId = mysqli_real_escape_string($conn, $_GET['course_id']);

    // Lấy user_ID dựa trên email được lưu trong session
    $email = $_SESSION['email'];
    $getUserIDQuery = "SELECT user_ID FROM User_General WHERE user_Email = '$email'";
    $userResult = mysqli_query($conn, $getUserIDQuery);
    $userRow = mysqli_fetch_assoc($userResult);
    $userId = $userRow['user_ID'];

    $deleteQuery = "DELETE FROM Student_Registration WHERE user_ID = '$userId' AND course_ID = '$courseId'";
    if (mysqli_query($conn, $deleteQuery)) {
        // Trả về phản hồi thành công
        header("Location: mycourse.php");
    } else {
        // Trả về phản hồi lỗi nếu cần
        header("HTTP/1.1 500 Internal Server Error");
        echo "Lỗi khi hủy đăng ký: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    // Nếu 'course_id' không tồn tại trong query parameter, chuyển hướng người dùng điều hướng về trang khác hoặc hiển thị thông báo lỗi
    header("Location: ../error_page.php");
}
