<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}
include "../connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Giáo Viên</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .container {
            margin-top: 80px;
        }

        .title {
            margin-top: 80px;
            text-align: center;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <?php include "m_header.php"; ?>
    <div class="container">

        <h2 class="title">DANH SÁCH GIÁO VIÊN</h2>

        <table class="table table-striped table-bordered">
            <thead>
                <th>Giáo viên</th>
                <th>Lớp giảng dạy</th>
            </thead>
            <tbody>
                <?php
                // Truy vấn lấy thông tin tất cả giáo viên
                $query = "SELECT user_ID, FullName FROM User_General WHERE role = 'teacher'";
                $result = $conn->query($query);

                // Kiểm tra và hiển thị danh sách giáo viên
                if ($result->num_rows > 0) {
                    while ($teacher = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td><a href="javascript:void(0);" class="view-details" data-id="' . $teacher['user_ID'] . '">' . $teacher['FullName'] . '</a></td>';
                        echo '<td><button class="view-classes" data-id="' . $teacher['user_ID'] . '">Xem</button></td>';
                        echo '</tr>';
                    }
                } else {
                    echo "Không có giáo viên nào.";
                }
                ?>

            </tbody>
        </table>

        <div class="teacher-details-container">

            <div class="teacher-details" id="teacher-details">
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.view-details').click(function() {
                    var teacherId = $(this).data('id');

                    // Sử dụng AJAX để tải thông tin chi tiết giáo viên
                    $.ajax({
                        url: 'teacher_detail.php',
                        type: 'GET',
                        data: {
                            id: teacherId
                        },
                        success: function(response) {
                            $('.teacher-details').html(response);
                            $('.teacher-details').show();
                        },
                        error: function() {
                            alert('Có lỗi xảy ra.');
                        }
                    });
                });
            });

            $(document).ready(function() {
                $('.view-classes').click(function() {
                    var teacherId = $(this).data('id');

                    // Sử dụng AJAX để tải thông tin chi tiết giáo viên
                    $.ajax({
                        url: 'classes_of_teacher.php',
                        type: 'GET',
                        data: {
                            id: teacherId
                        },
                        success: function(response) {
                            $('.teacher-details').html(response);
                            $('.teacher-details').show();
                        },
                        error: function() {
                            alert('Có lỗi xảy ra.');
                        }
                    });
                });
            });
        </script>

    </div>
</body>

</html>