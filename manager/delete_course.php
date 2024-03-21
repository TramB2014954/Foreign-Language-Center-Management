<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}

include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['course_id'])) {
    $courseID = $_GET['course_id'];

    // Xóa các bản ghi từ bảng Class_Day liên quan đến course_ID
    $deleteClassDayQuery = "DELETE FROM Class_Day WHERE course_ID = $courseID";

    if (mysqli_query($conn, $deleteClassDayQuery)) {
        // Nếu xóa Class_Day thành công, tiếp tục xóa khóa học từ bảng Course
        $deleteCourseQuery = "DELETE FROM Course WHERE course_ID = $courseID";
        if (mysqli_query($conn, $deleteCourseQuery)) {
            header("Location: m_homepage.php");
            exit();
        } else {
            echo "Lỗi khi xóa khóa học: " . mysqli_error($conn);
        }
    } else {
        echo "Lỗi khi xóa dữ liệu liên quan trong bảng Class_Day: " . mysqli_error($conn);
    }
}
