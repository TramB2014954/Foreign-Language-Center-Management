<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}

include '../connection.php';

$courseID = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

$query = "SELECT * FROM Course WHERE course_ID = $courseID";
$result = mysqli_query($conn, $query);

if ($result) {
    $courseInfo = mysqli_fetch_assoc($result);

    // Lấy danh sách giáo viên
    $teacherQuery = "SELECT User_General.FullName FROM Teacher_Registration
                     INNER JOIN User_General ON Teacher_Registration.user_ID = User_General.user_ID
                     WHERE Teacher_Registration.course_ID = $courseID AND Teacher_Registration.status = 'approved'";

    $teacherResult = mysqli_query($conn, $teacherQuery);
    $teachers = [];

    while ($teacher = mysqli_fetch_assoc($teacherResult)) {
        $teachers[] = $teacher['FullName'];
    }

    // Lấy danh sách học viên
    $studentQuery = "SELECT User_General.FullName FROM Student_Registration
                     INNER JOIN User_General ON Student_Registration.user_ID = User_General.user_ID
                     WHERE Student_Registration.course_ID = $courseID";

    $studentResult = mysqli_query($conn, $studentQuery);
    $students = [];

    while ($student = mysqli_fetch_assoc($studentResult)) {
        $students[] = $student['FullName'];
    }
} else {
    echo "Không tìm thấy thông tin cho khóa học này.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin chi tiết về khóa học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            justify-content: center;

        }

        .title {
            margin-top: 80px;
            text-align: center;
        }

        .container-small {
            width: 80%;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            justify-content: center;
            margin: 0;
        }

        table {
            width: 70%;
            border-collapse: collapse;
            margin-top: 10px;
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
    <?php include "m_header.php"; ?>

    <h2 class="title">DANH SÁCH LỚP</h2>

    <div class="container-small">
        <p><strong>Tên khóa học:</strong> <?php echo $courseInfo['Class_Name'] . " - " . $courseInfo['course_Name']; ?></p>

        <p><strong>Giáo viên đảm nhận:</strong>
            <?php
            if (!empty($teachers)) {
                echo implode(", ", $teachers);
            } else {
                echo "Chưa có giáo viên.";
            }
            ?>
        </p>

        <p><strong>Danh sách học viên:</strong></p>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên học viên</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stt = 1;
                foreach ($students as $student) {
                    echo "<tr>";
                    echo "<td>$stt</td>";
                    echo "<td>$student</td>";
                    echo "</tr>";
                    $stt++;
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>