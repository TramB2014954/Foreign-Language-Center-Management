<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}
include "../connection.php";

$teacherEmail = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #e8f2ff;
        }

        .header-image {
            margin-top: 20px;
            margin-bottom: 20px;
            position: relative;
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input {
            width: 300px;
            padding: 8px;
            border: none;
            border-radius: 20px;
            outline: none;
        }

        .search-button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            margin-left: 10px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #0056b3;
        }

        .container {
            padding-top: 70px;
        }

        .course-card {
            margin-right: 20px;
        }

        .card {
            margin-bottom: 30px;
        }


        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 50px;
        }

        .pagination a {
            color: #007bff;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
            margin: 0 5px;
            border: 1px solid #007bff;
            border-radius: 4px;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination .current {
            background-color: #007bff;
            color: white;
        }

        .course-card:hover {
            transform: scale(1.02);
            transition: 0.3s;
        }
    </style>
</head>

<body>
    <?php include 'header.php' ?>
    <div class="container">
        <h4>Xin chào, <?php echo $teacherEmail; ?></h4>

        <img src="../image/homepage.jpg" alt="Homepage Image" class="header-image">

        <h3>Danh sách khóa học</h3>

        <div class="form-group search-container">
            <input type="text" class="form-control search-input" id="searchInput" placeholder="Nhập tên khóa học...">
            <button class="btn btn-primary search-button" onclick="searchCourses()">Tìm Kiếm</button>
        </div>
        <div id="noResultsMessage" style="display: none; color: red; margin-top: 10px;">Không tìm thấy kết quả phù hợp.
        </div>

        <div class="row" id="courseList">

            <div class="row">
                <?php
                include '../connection.php';

                // Tính tổng số khóa học trong CSDL (ví dụ)
                $tongSoKhoaHoc = 50;

                // Số lượng khóa học hiển thị trên mỗi trang
                $soLuongKhoaHocTrenMotTrang = 8;

                // Trang hiện tại
                if (isset($_GET['trang']) && is_numeric($_GET['trang'])) {
                    $trangHienTai = $_GET['trang'];
                } else {
                    $trangHienTai = 1;
                }

                // Tính vị trí bắt đầu của khóa học trên trang hiện tại
                $viTriBatDau = ($trangHienTai - 1) * $soLuongKhoaHocTrenMotTrang;

                // Câu truy vấn SQL với LIMIT
                $sql = "SELECT c.*
                        FROM Course c
                        LEFT JOIN Teacher_Registration tr ON c.course_ID = tr.course_ID
                        WHERE tr.registration_id IS NULL OR tr.status IN ('pending', 'rejected') LIMIT $viTriBatDau, $soLuongKhoaHocTrenMotTrang";
                $result = mysqli_query($conn, $sql);

                // Tổng số trang
                $tongSoTrang = ceil($tongSoKhoaHoc / $soLuongKhoaHocTrenMotTrang);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="course-card">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['course_Name'] . '</h5>';
                    echo '<p class="card-text">Giá: ' . number_format($row['course_Fee']) . ' VND</p>';
                    echo '<p class="card-text">Số lượng học viên: ' . (isset($row['course_AvailableSlot']) ? $row['course_AvailableSlot'] : 'Hết chỗ') . '</p>';
                    echo '<a href="course_detail.php?course_id=' . $row['course_ID'] . '" class="">[Xem chi tiết]</a>';
                    echo '</div></div></div>';
                }
                ?>

            </div>
        </div>

        <div class="pagination">
            <?php
            $showPages = 5;
            $startPage = max(1, min($tongSoTrang - $showPages + 1, $trangHienTai - intval($showPages / 2)));
            $endPage = min($tongSoTrang, $startPage + $showPages - 1);

            if ($trangHienTai > 1) {
                echo '<a href="?trang=' . ($trangHienTai - 1) . '">&laquo;</a>';
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                $class = ($i == $trangHienTai) ? 'current' : '';
                echo '<a class="' . $class . '" href="?trang=' . $i . '">' . $i . '</a>';
            }

            if ($trangHienTai < $tongSoTrang) {
                echo '<a href="?trang=' . ($trangHienTai + 1) . '">&raquo;</a>';
            }
            ?>
        </div>


    </div>

    <?php include '../aboutus.html' ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Hàm tìm kiếm khóa học
        function searchCourses() {
            var searchTerm = document.getElementById("searchInput").value.toLowerCase();
            var courseList = document.getElementById("courseList");
            var courses = courseList.getElementsByClassName("course-card");
            document.getElementById("searchInput").addEventListener("keyup", function(event) {
                if (event.key === "Enter") {
                    searchCourses();
                }
            });
            // Lặp qua danh sách khóa học và ẩn hoặc hiển thị tùy theo kết quả tìm kiếm
            for (var i = 0; i < courses.length; i++) {
                var courseName = courses[i].getElementsByClassName("card-title")[0].innerText.toLowerCase();
                if (courseName.includes(searchTerm)) {
                    courses[i].style.display = "block";
                } else {
                    courses[i].style.display = "none";
                }
            }
            var noResultsMessage = document.getElementById("noResultsMessage");

            var foundResults = false;

            // Hiển thị hoặc ẩn thông báo không tìm thấy kết quả
            if (!foundResults) {
                noResultsMessage.style.display = "block";
            } else {
                noResultsMessage.style.display = "none";
            }
        }

        //load lại trang mỗi khi click logo
        function reloadPage() {
            window.location.href = "homepage.php";
            location.reload();
        }
    </script>

</body>

</html>