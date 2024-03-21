<?php
include "../connection.php";

if (isset($_POST['selectedType'])) {
    $selectedType = mysqli_real_escape_string($conn, $_POST['selectedType']);

    // Truy vấn để lấy tên khóa học tương ứng với loại khóa học đã chọn
    $query = "SELECT TC_Name FROM Type_Course WHERE TC_ID = '$selectedType'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo $row['TC_Name'];
    }
}

mysqli_close($conn);
