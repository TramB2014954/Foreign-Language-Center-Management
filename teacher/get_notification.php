<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}

include "../connection.php";

$userEmail = $_SESSION['email'];

$userIDQuery = "SELECT user_ID FROM User_General WHERE user_Email = '$userEmail'";
$userIDResult = mysqli_query($conn, $userIDQuery);

if ($userIDResult) {
    $userData = mysqli_fetch_assoc($userIDResult);
    if ($userData) {
        $userID = $userData['user_ID'];
        $notificationQuery = "SELECT N.notice_id, N.notice_status, N.registration_id, R.status, R.user_id, C.course_Name
            FROM Notice N
            JOIN Teacher_Registration R ON N.registration_id = R.registration_id
            JOIN Course C ON R.course_ID = C.course_ID
            WHERE R.user_ID = $userID";

        $notificationResult = mysqli_query($conn, $notificationQuery);

        if ($notificationResult) {
            // Kiểm tra xem có thông báo nào không
            $hasNotification = false;

            while ($notification = mysqli_fetch_assoc($notificationResult)) {
                $noticeID = $notification['notice_id'];
                $noticeStatus = $notification['notice_status'];
                $registrationID = $notification['registration_id'];
                $registrationStatus = $notification['status'];
                $courseName = $notification['course_Name'];

                $notificationContent = "";
                if ($registrationStatus == 'approved') {
                    $notificationContent = "Bạn đã được duyệt dạy khóa học $courseName";
                } elseif ($registrationStatus == 'rejected') {
                    $notificationContent = "Bạn đã bị từ chối dạy khóa học $courseName";
                }

                // Nếu có thông báo, đặt hasNotification thành true
                if (!empty($notificationContent)) {
                    $hasNotification = true;
                    echo '<div class="contentt">' . $notificationContent . '</div>';
                    echo '<hr class="separator">';
                }
            }

            // Nếu không có thông báo, hiển thị "Không có thông báo"
            if (!$hasNotification) {
                echo '<div class="contentt">Không có thông báo</div>';
            }
        } else {
            echo "Query failed: " . mysqli_error($conn);
        }
    } else {
        echo "User data not found";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .contentt {
            background-color: #f6fff8;
            font-size: smaller;
        }

        .contentt:hover {
            box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.2);
        }

        .separator {
            margin: 0;
        }
    </style>
</head>

<body>

</body>

</html>