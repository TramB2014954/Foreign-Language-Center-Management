<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dang ki hoc vien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h3 {
            margin-bottom: 20px;
            color: #007bff;
        }

        table {
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }

        table td {
            text-align: left;
            padding: 8px;
        }

        table td:last-child {
            justify-content: center;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            justify-content: center;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
        }
    </style>
</head>

<body>
    <form action="register_submit.php" method="post">
        <table>
            <h3>ĐĂNG KÍ TÀI KHOẢN</h3>
            <?php
            if (isset($_SESSION['email_error'])) {
                echo '<tr><td colspan="2" class="error-message">' . $_SESSION['email_error'] . '</td></tr>';
                unset($_SESSION['email_error']);
            }

            if (isset($_SESSION['password_error'])) {
                echo '<tr><td colspan="2" class="error-message">' . $_SESSION['password_error'] . '</td></tr>';
                unset($_SESSION['password_error']);
            }

            if (isset($_SESSION['registration_error'])) {
                echo '<tr><td colspan="2" class="error-message">' . $_SESSION['registration_error'] . '</td></tr>';
                unset($_SESSION['registration_error']);
            }
            ?>
            <tr>
                <td>Họ tên</td>
                <td><input type="text" name="fullname"></td>
            </tr>
            <tr>
                <td>Số điện thoại</td>
                <td><input type="text" name="phonenumber"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" name="email"></td>
            </tr>
            <tr>
                <td>Mật khẩu</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td>Nhập lại Mật khẩu</td>
                <td><input type="password" name="repassword"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="submit">Đăng kí</button>
                    <button type="reset">Làm mới</button>
                </td>
            </tr>
        </table>
        <hr>
        <p>Đã có tài khoản? <a href="../login/login.php">Đăng nhập</a></p>
    </form>
</body>

</html>