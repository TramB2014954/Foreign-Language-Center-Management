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
    <title>THÊM KHÓA HỌC</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .title {
            margin-top: 80px;
            text-align: center;
        }


        #addCourseForm {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .left {
            display: flex;
            flex-direction: column !important;
        }

        .right {
            display: flex;
            flex-direction: column !important;
        }

        #error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php include 'm_header.php' ?>

    <div class="container mt-5">
        <h2 class="title">THÊM KHÓA HỌC</h2>
        <form action="insert_course_submit.php" method="post" id="addCourseForm">

            <div class="left">
                <div id="error-message" class="alert alert-danger <?php echo $errorMessage ? '' : 'd-none'; ?>">
                    <?php echo $errorMessage; ?>
                </div>
                <div class="form-group">
                    <label for="courseName">Tên Khóa Học:</label>
                    <input type="text" class="form-control" id="courseName" name="courseName" required>
                </div>
                <div class="form-group">
                    <label for="courseType">Loại Khóa Học:</label>
                    <select class="form-control" id="courseType" name="courseType" required>
                        <?php
                        $query = "SELECT TC_ID, TC_Name FROM Type_Course";
                        $result = mysqli_query($conn, $query);

                        // Hiển thị tùy chọn trong dropdown menu
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['TC_ID'] . "'>" . $row['TC_Name'] . "</option>";
                        }
                        ?>
                    </select>
                    </select>
                </div>
                <div class="form-group">
                    <label for="className">Tên lớp</label>
                    <input type="text" class="form-control" id="className" name="className" required>
                </div>
                <div class="form-group">
                    <label for="courseFee">Học Phí (VND):</label>
                    <input type="text" class="form-control" id="courseFee" name="courseFee" oninput="formatCurrency(this);" required>
                </div>
                <div class="form-group">
                    <label for="totalSlots">Tổng Số Lượng Chỗ:</label>
                    <input type="number" class="form-control" id="totalSlots" name="totalSlots" required>
                </div>

                <div class="form-group form-inline">
                    <label for="startDate">Ngày Bắt Đầu:</label>
                    <input type="date" class="form-control" id="startDate" name="startDate" required>
                    <label for="endDate">Ngày Kết Thúc:</label>
                    <input type="date" class="form-control" id="endDate" name="endDate" required>
                </div>
            </div>
            <div class="form-group">
                <label>Ngày Học:</label><br>
                <?php
                $query = "SELECT Day_ID, Day_Of_Week FROM Day_Of_Week";
                $result = mysqli_query($conn, $query);
                // Hiển thị các ngày dưới dạng checkbox
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="checkbox" id="' . $row['Day_Of_Week'] . '" name="dayOfWeek[]" value="' . $row['Day_ID'] . '">';
                    echo '<label class="form-check-label" for="' . $row['Day_ID'] . '">' . $row['Day_Of_Week'] . '</label>';
                    echo '</div>';
                }
                ?>
            </div>

            <div class="right">
                <div class="form-group">
                    <label for="classTime">Ca Học:</label>
                    <select class="form-control" id="classTime" name="classTime" required>
                        <?php
                        $query = "SELECT * FROM Class_Session";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['Class_ID'] . '">' . $row['Class_Time'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" onclick="return validateForm()">THÊM</button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function submitForm() {
            // Lấy form theo ID
            var form = document.getElementById("addCourseForm");
            // Submit form
            form.submit();
        }

        $(document).ready(function() {
            // Sự kiện khi người dùng chọn một loại khóa học
            $("#courseType").change(function() {
                // Lấy giá trị của loại khóa học đã chọn
                var selectedType = $(this).val();

                // Gọi hàm AJAX để lấy thông tin về tên khóa học tương ứng
                $.ajax({
                    url: 'get_course_name.php', // Thay đổi đường dẫn đến file xử lý AJAX
                    method: 'POST',
                    data: {
                        'selectedType': selectedType
                    },
                    success: function(data) {
                        // Cập nhật giá trị của ô tên khóa học
                        $("#courseName").val(data);
                    }
                });
            });
        });

        function validateForm() {
            // Kiểm tra các điều kiện và hiển thị thông báo lỗi nếu cần
            var courseName = document.getElementById("courseName").value;
            var className = document.getElementById("className").value;
            var courseFee = document.getElementById("courseFee").value;
            var totalSlots = document.getElementById("totalSlots").value;
            var startDate = document.getElementById("startDate").value;
            var endDate = document.getElementById("endDate").value;
            var checkboxes = document.getElementsByName("dayOfWeek[]");

            // Kiểm tra xem ít nhất một checkbox đã được chọn hay không
            var atLeastOneChecked = false;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    atLeastOneChecked = true;
                    break;
                }
            }

            // Hiển thị hoặc ẩn thông báo lỗi trong div "error-message"
            var errorMessageDiv = document.getElementById("error-message");
            errorMessageDiv.innerHTML = ""; // Xóa nội dung trước đó

            if (courseName === "" || className === "" || courseFee === "" || totalSlots === "" || startDate === "" || endDate === "" || !atLeastOneChecked) {
                errorMessageDiv.innerHTML = "Vui lòng điền đầy đủ thông tin.";
                errorMessageDiv.classList.remove("d-none");
                return false;
            }

            errorMessageDiv.classList.add("d-none");
            return true;
        }



        function formatCurrency(input) {
            let inputValue = input.value;
            inputValue = inputValue.replace(/[^0-9]/g, '');
            input.value = inputValue;
        }
    </script>

</body>

</html>