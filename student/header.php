<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh tiêu đề</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.20.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .header {
            background-color: white;
            color: black;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 999;
            box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .right p:first-child {
            padding-right: 20px;
        }

        .left h2 {
            font-family: fantasy;
            color: black;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .left a {
            text-decoration: none;
        }

        .left h2 {
            transition: transform 0.2s ease;
        }

        .left h2:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        .right {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: #35509a;
            font-weight: 500;
            font-size: 25px;
        }

        .right a {
            padding-right: 10px;
            color: #35509a;

        }

        .right i {
            transition: transform 0.2s ease;
        }

        .right i:hover {
            transform: scale(1.05);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="left">
            <a href="homepage.php" onclick="reloadPage()">
                <h2>LANGMASTER</h2>
            </a>
        </div>
        <div class="right">
            <a href="mycourse.php" class=""><i class="	far fa-calendar-check"></i></a>
            <a href="logout.php" class=""><i class="fa-solid fa-right-from-bracket"></i></a>

        </div>
    </div>
</body>

</html>