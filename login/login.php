<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
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
            color: #007bff;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
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

        form input[type="text"],
        form input[type="password"] {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .register-link {
            margin-top: 10px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
        }
    </style>
</head>

<body>
    <div class="login-container">

        <br>
        <form action="login_submit.php" method="post">
            <table>
                <h3>ĐĂNG NHẬP</h3>

                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
                    echo '<tr><td colspan="2" class="error-message">Email hoặc mật khẩu không chính xác!</td></tr>!';
                }
                ?>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="email" required></td>
                </tr>
                <tr>
                    <td>Mật khẩu: </td>
                    <td><input type="password" name="password" required></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <button type="submit" name="submit">Đăng nhập</button>
                        <button type="reset">Làm mới</button>
                    </td>
                </tr>


            </table>
            <br><br>
            <input type="checkbox" name="rememberMe" id="rememberMe">
            <a>Remember me</a>
            <a href="">Quên mật khẩu?</a>
            <hr>
            <br>
            <p style="align-items:center" ;>Bạn chưa có tài khoản? <a href="../student/register.php" class="register-link">Đăng kí </a></p>

        </form>

    </div>
</body>

</html>