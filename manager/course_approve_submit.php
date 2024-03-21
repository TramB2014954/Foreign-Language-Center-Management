<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}

include "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && isset($_GET['status'])) {
    $registrationID = mysqli_real_escape_string($conn, $_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    if ($status == "approved" || $status == "rejected") {
        mysqli_autocommit($conn, FALSE);

        $updateStatusQuery = $conn->prepare("UPDATE Teacher_Registration SET status = ? WHERE registration_id = ?");
        $updateStatusQuery->bind_param("si", $status, $registrationID);
        $updateStatusQuery->execute();

        if ($updateStatusQuery->affected_rows > 0) {
            $insertNoticeQuery = $conn->prepare("INSERT INTO Notice (registration_id, notice_status) SELECT registration_id, 1 FROM Teacher_Registration WHERE registration_id = ?");
            $insertNoticeQuery->bind_param("i", $registrationID);
            $insertNoticeQuery->execute();

            if ($insertNoticeQuery->affected_rows > 0) {
                mysqli_commit($conn);
            } else {
                mysqli_rollback($conn);
            }
        } else {
            mysqli_rollback($conn);
        }

        mysqli_autocommit($conn, TRUE);

        header("Location: course_approve.php");
        exit();
    } else {
        // ...
    }
} else {
    // ...
}
