<?php
session_start();
session_destroy(); // Hủy bỏ phiên làm việc

// Chuyển hướng đến trang đăng nhập
header("Location: ../login/login.php");
exit();
?>