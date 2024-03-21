<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}
include "../connection.php";

$teacherEmail = $_SESSION['email'];

// Lấy thông tin người dùng từ CSDL dựa trên email
$query = "SELECT * FROM User_General WHERE user_Email = '$teacherEmail'";
$result = mysqli_query($conn, $query);
$teacher = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và kiểm tra tính hợp lệ
    $FullName = mysqli_real_escape_string($conn, $_POST['FullName']);
    $PhoneNumber = mysqli_real_escape_string($conn, $_POST['PhoneNumber']);
    $teacher_Address = mysqli_real_escape_string($conn, $_POST['teacher_Address']);
    $teacher_birthday = mysqli_real_escape_string($conn, $_POST['teacher_birthday']);
    $teacher_gender = mysqli_real_escape_string($conn, $_POST['teacher_gender']);
    $teacher_nationality = mysqli_real_escape_string($conn, $_POST['teacher_nationality']);
    $teacher_Specialization = mysqli_real_escape_string($conn, $_POST['teacher_Specialization']);
    $teacher_experience = mysqli_real_escape_string($conn, $_POST['teacher_experience']);
    $teacher_Qualification = mysqli_real_escape_string($conn, $_POST['teacher_Qualification']);

    // Thực hiện truy vấn SQL để cập nhật thông tin giáo viên
    $updateQuery = $conn->prepare("UPDATE User_General SET FullName=?, PhoneNumber=?, teacher_Address=?, teacher_birthday=?, teacher_gender=?, teacher_nationality=?, teacher_Specialization=?, teacher_experience=?, teacher_Qualification=? WHERE user_Email=?");
    $updateQuery->bind_param("ssssssssss", $FullName, $PhoneNumber, $teacher_Address, $teacher_birthday, $teacher_gender, $teacher_nationality, $teacher_Specialization, $teacher_experience, $teacher_Qualification, $teacherEmail);
    $updateQuery->execute();
    $updateQuery->close();

    // Redirect to the current page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Thông Tin Giáo Viên</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #e8f2ff;
        }

        .title {
            margin-top: 80px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include 'header.php' ?>

    <div class="container mt-5">
        <h2 class="title">HỒ SƠ CÁ NHÂN</h2>
        <form id="updateForm" action="" method="post">
            <div class="form-group">
                <?php
                if (!empty($teacher['teacher_image'])) {
                    echo '<img style=" width: 150px" src="../image/' . $teacher['teacher_image'] . '" alt="Ảnh giáo viên">';
                } else {
                    echo 'Không có hình ảnh.';
                }
                ?>
            </div>
            <div class=" form-group">
                <label for="FullName">Họ và Tên:</label>
                <input type="text" class="form-control" id="FullName" name="FullName" value="<?php echo $teacher['FullName']; ?>" required>
            </div>
            <div class="form-group">
                <label for="PhoneNumber">Số Điện Thoại:</label>
                <input type="text" class="form-control" id="PhoneNumber" name="PhoneNumber" value="<?php echo $teacher['PhoneNumber']; ?>">
            </div>

            <div class="form-group">
                <label for="teacher_Address">Địa Chỉ:</label>
                <input type="text" class="form-control" id="teacher_Address" name="teacher_Address" value="<?php echo $teacher['teacher_Address']; ?>">
            </div>
            <div class="form-group">
                <label for="teacher_birthday">Ngày Sinh:</label>
                <input type="date" class="form-control" id="teacher_birthday" name="teacher_birthday" value="<?php echo $teacher['teacher_birthday']; ?>">
            </div>
            <div class="form-group">
                <label for="teacher_gender">Giới Tính:</label>
                <select class="form-control" id="teacher_gender" name="teacher_gender">
                    <option value="Nam" <?php echo ($teacher['teacher_gender'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                    <option value="Nữ" <?php echo ($teacher['teacher_gender'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                </select>
            </div>
            <div class="form-group">
                <label for="teacher_nationality">Dân Tộc:</label>
                <input type="text" class="form-control" id="teacher_nationality" name="teacher_nationality" value="<?php echo $teacher['teacher_nationality']; ?>">
            </div>
            <div class="form-group">
                <label for="teacher_Specialization">Chuyên Môn:</label>
                <input type="text" class="form-control" id="teacher_Specialization" name="teacher_Specialization" value="<?php echo $teacher['teacher_Specialization']; ?>">
            </div>
            <div class="form-group">
                <label for="teacher_experience">Kinh Nghiệm Giảng Dạy:</label>
                <textarea class="form-control" id="teacher_experience" name="teacher_experience"><?php echo $teacher['teacher_experience']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="teacher_Qualification">Trình Độ:</label>
                <input type="text" class="form-control" id="teacher_Qualification" name="teacher_Qualification" value="<?php echo $teacher['teacher_Qualification']; ?>">
            </div>
            <button type="submit" class="btn btn-primary" onclick="confirmUpdate()">Cập Nhật</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function confirmUpdate() {
            if (confirm("Bạn có chắc chắn muốn cập nhật thông tin không?")) {
                document.getElementById("updateForm").submit();
            }
        }
    </script>
</body>

</html>