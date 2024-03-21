<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}

include "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && isset($_GET['status'])) {
    $registration_id = $_GET['id'];
    $status = $_GET['status'];

    $registrationQuery = $conn->prepare("SELECT course_ID, user_ID, status FROM Teacher_Registration WHERE registration_id = ?");
    $registrationQuery->bind_param("i", $registration_id);
    $registrationQuery->execute();
    $registrationResult = $registrationQuery->get_result();
    $registrationData = $registrationResult->fetch_assoc();

    if ($status == 'approved') {
        $conn->begin_transaction();

        $updateApprovedQuery = $conn->prepare("UPDATE Teacher_Registration SET status = 'approved' WHERE registration_id = ?");
        $updateApprovedQuery->bind_param("i", $registration_id);
        $updateApprovedQuery->execute();

        $rejectOthersQuery = $conn->prepare("UPDATE Teacher_Registration SET status = 'rejected' WHERE course_ID = ? AND status = 'pending' AND registration_id != ?");
        $rejectOthersQuery->bind_param("ii", $registrationData['course_ID'], $registration_id);
        $rejectOthersQuery->execute();

        $conn->commit();
    } elseif ($status == 'rejected') {
        $rejectQuery = $conn->prepare("UPDATE Teacher_Registration SET status = 'rejected' WHERE registration_id = ?");
        $rejectQuery->bind_param("i", $registration_id);
        $rejectQuery->execute();
    }
}

$allRegistrationsQuery = $conn->prepare("SELECT registration_id, u.user_ID, u.FullName, c.course_ID, c.course_Name, registration_date, status 
                                       FROM Teacher_Registration 
                                       JOIN Course c ON Teacher_Registration.course_ID = c.course_ID 
                                       JOIN User_General u ON Teacher_Registration.user_ID = u.user_ID 
                                       ORDER BY CASE WHEN status = 'pending' THEN 1 ELSE 2 END, registration_date DESC");

$allRegistrationsQuery->execute();
$allRegistrationsResult = $allRegistrationsQuery->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyệt Khóa Học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 80px;
        }

        .title {
            margin-top: 80px;
            text-align: center;
        }

        #icon {
            font-size: 20px;
        }

        #icon:first-child {
            padding-right: 30px;
        }
    </style>
</head>

<body>
    <?php include "m_header.php"; ?>
    <div class="container">
        <h2 class="title">DANH SÁCH ĐĂNG KÍ</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên giáo viên</th>
                    <th>Khóa học</th>
                    <th>Thời gian đăng kí</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;

                while ($row = $allRegistrationsResult->fetch_assoc()) {
                    echo "<tr>
                            <td>{$count}</td>
                            <td>  {$row['FullName']}</td>
                            <td>ID:{$row['course_ID']} - {$row['course_Name']}</td>
                            </td>"
                ?>
                    <td>
                        <?php
                        $registrationDate = date('H:i:s d-m-Y', strtotime($row['registration_date']));
                        echo $registrationDate;
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($row['status'] == 'approved') {
                            echo "<span style='color: green;'>Đã chấp nhận</span>";
                        } elseif ($row['status'] == 'rejected') {
                            echo "<span style='color: red;'>Đã từ chối</span>";
                        } else {
                            echo "<span style='color: orange;'>Chờ duyệt</span>";
                            echo "<br>";
                        }
                        ?>
                    <td>
                    <?php
                    if ($row['status'] == 'approved' || $row['status'] == 'rejected') {
                        echo "Đã duyệt";
                    } else {
                        echo "<a href='course_approve_submit.php?id={$row['registration_id']}&status=approved'><i class='fas fa-check text-success' id='icon'></i></a>
                                <a href='course_approve_submit.php?id={$row['registration_id']}&status=rejected'><i class='fas fa-times text-danger' id='icon'></i></a>";
                    }


                    echo "</td>
                        </tr>";
                    $count++;
                }
                    ?>
            </tbody>
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>