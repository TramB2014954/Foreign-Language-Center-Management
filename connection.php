<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "QuanLyTTNN";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
?>