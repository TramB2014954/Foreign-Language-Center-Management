<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
include "../connection.php";



$teacherEmail = $_SESSION['email'];
$sql_user = "SELECT user_ID FROM User_General WHERE user_Email = '$teacherEmail'";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $user_ID = $row_user['user_ID'];

    // Truy vấn dữ liệu các khóa học đã được giáo viên đăng ký và được duyệt
    $sql_courses = "SELECT c.course_ID, c.course_Name, c.Class_Name, c.StartDate, c.EndDate, cs.Class_Time, GROUP_CONCAT(DISTINCT cd.Day_ID ORDER BY cd.Day_ID) AS Day_IDs
                    FROM Course c
                    JOIN Class_Session cs ON c.Class_ID = cs.Class_ID
                    JOIN Class_Day cd ON c.course_ID = cd.course_ID
                    JOIN Teacher_Registration tr ON c.course_ID = tr.course_ID
                    WHERE tr.user_ID = $user_ID AND tr.status = 'approved'
                    GROUP BY c.course_ID, c.course_Name, c.Class_Name, c.StartDate, c.EndDate, cs.Class_Time";

    $result_courses = $conn->query($sql_courses);
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch dạy</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #e8f2ff;
        }

        .title {
            margin-top: 80px;
            text-align: center;
        }

        .table-container {
            width: 70%;
            margin: 10px auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <h2 class="title">LỊCH DẠY</h2>

    <div class="table-container">
        <?php
        if ($result_courses->num_rows > 0) {
            echo "<table class='table'>
                <thead>
                    <tr>
                        <th>Khóa học</th>
                        <th>Lớp</th>
                        <th>Bắt đầu</th>
                        <th>Kết thúc</th>
                        <th>Thứ</th>
                        <th>Ca dạy</th>
                    </tr>
                </thead>
                <tbody>";

            while ($row = $result_courses->fetch_assoc()) {
                $startDate = date('d-m-Y', strtotime($row['StartDate']));
                $endDate = date('d-m-Y', strtotime($row['EndDate']));
                echo "<tr>
                <td>{$row['course_Name']}</td>
                <td>{$row['Class_Name']}</td>
                <td>{$startDate}</td>
                <td>{$endDate}</td>
                <td>";

                $dayIds = explode(',', $row['Day_IDs']);
                foreach ($dayIds as $dayId) {
                    echo "$dayId ";
                }

                echo "</td>
                <td>{$row['Class_Time']}</td>
              </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No approved courses found for this teacher.</p>";
        }

        $conn->close();
        ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>