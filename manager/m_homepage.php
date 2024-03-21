<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}


include '../connection.php';

$query = "SELECT Course.course_ID, course_Name, course_Fee, course_TotalSlot, course_AvailableSlot, DATE_FORMAT(StartDate, '%d-%m-%Y') AS StartDate, DATE_FORMAT(EndDate, '%d-%m-%Y') AS EndDate, TC_ID, Class_Session.Class_Time, GROUP_CONCAT(Day_ID) AS DaysOfWeek
          FROM Course
          LEFT JOIN Class_Day ON Course.course_ID = Class_Day.course_ID
          LEFT JOIN Class_Session ON Course.Class_ID = Class_Session.Class_ID
          GROUP BY Course.course_ID";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ Quản Lý</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .container {
            margin-top: 80px;
        }

        .title {
            text-align: center;
        }

        h4 {
            margin-bottom: 20px;
        }

        .btn-group {
            margin-bottom: 20px;
        }

        .modal-backdrop.show {
            opacity: 0;
        }

        .modal-content {
            background-color: #ffffff;
            color: #333333;
            border-radius: 10px;
            width: 400px;
        }

        .modal-header {
            background-color: #E5F0BB;
        }
    </style>
</head>

<body>
    <?php include 'm_header.php' ?>
    <div class="container">
        <h4>Xin chào, <?php echo $teacherEmail; ?></h4>

        <div class="btn-group" role="group" aria-label="Chức năng">

        </div>

        <h2 class="title">DANH SÁCH KHÓA HỌC</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Học Phí</th>
                    <th>Tổng Số Lượng Chỗ</th>
                    <th>Chưa đăng kí</th>
                    <th>Bắt Đầu</th>
                    <th>Kết Thúc</th>
                    <th>Ngày Học</th>
                    <th>Ca Học</th>
                    <th>Xem</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['course_Name']}</td>";
                    echo "<td>{$row['course_Fee']}</td>";
                    echo "<td>{$row['course_TotalSlot']}</td>";
                    echo "<td>{$row['course_AvailableSlot']}</td>";
                    echo "<td>{$row['StartDate']}</td>";
                    echo "<td>{$row['EndDate']}</td>";
                    echo "<td>{$row['DaysOfWeek']}</td>";
                    echo "<td>{$row['Class_Time']}</td>";
                    echo "<td>";
                    echo "<a href='course_in4.php?course_id={$row['course_ID']}''>Xem chi tiết</a>";
                    echo "</td>";
                    echo "<td>";
                    echo "<a href='#' onclick='deleteCourse({$row['course_ID']}, \"{$row['StartDate']}\")' class='btn btn-danger'>Xóa</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="modal" id="successModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Khóa học được thêm thành công!<i class="fas fa-check-circle text-success"></i></h5>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function deleteCourse(courseID, startDate) {
            var currentTime = new Date();
            var courseStartDateSlipt = startDate.split('-');
            var courseStartDate = new Date(courseStartDateSlipt[2], courseStartDateSlipt[1] - 1, courseStartDateSlipt[0]);

            console.log(currentTime, courseStartDate);

            if (courseStartDate <= currentTime) {
                alert("Khóa học đã mở lớp, không thể xóa.");
            } else {
                var confirmDelete = confirm("Bạn có chắc chắn muốn xóa khóa học này?");
                if (confirmDelete) {
                    // Chuyển hướng đến trang xử lý xóa với course_id
                    window.location.href = `delete_course.php?course_id=${courseID}`;
                }
            }
        }

        function showSuccessModal() {
            $('#successModal').modal({
                backdrop: 'static',
                keyboard: false
            });

            setTimeout(function() {
                $('#successModal').modal('hide');
            }, 1000);
        }

        function submitForm() {
            // Lấy form theo ID
            var form = document.getElementById("addCourseForm");
            form.submit();
            showSuccessModal();
        }
    </script>
    <?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo '<script>showSuccessModal();';
        echo 'window.history.replaceState({}, document.title, "' . strtok($_SERVER["REQUEST_URI"], '?') . '");</script>';
    }
    ?>

</body>

</html>