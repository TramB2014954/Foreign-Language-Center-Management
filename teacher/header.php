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

        .notification {
            display: none;
            position: fixed;
            z-index: 1000000;
            top: 70px;
            width: 270px;
            height: fit-content;
            right: 125px;
            background-color: #f6fff8;
            box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="left">
            <a href="homepage_teacher.php" onclick="reloadPage()">
                <h2>LANGMASTER</h2>
            </a>
        </div>
        <div class="right">
            <a href="schedule.php">
                <i class="far fa-calendar-check"></i>
            </a>
            <a href="#" onclick="return false">
                <i class="fa-solid fa-bell" onclick="toggleNotification()"></i>
            </a>
            <a href="update_in4.php">
                <i class="fa-solid fa-user"></i>
            </a>
            <a href="logout.php" class=""><i class="fa-solid fa-right-from-bracket"></i></a>

        </div>
    </div>

    <div class="notification" id="notification">
    </div>

    <script>
        function reloadPage() {
            location.reload();
        }

        function toggleNotification() {
            var notification = document.getElementById("notification");

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        notification.innerHTML = xhr.responseText;
                        notification.style.display = notification.style.display === "none" ? "block" : "none";
                    } else {
                        console.error("Error fetching notification:", xhr.status, xhr.statusText);
                    }
                }
            };
            xhr.open("GET", "get_notification.php", true);
            xhr.send();

        }
    </script>
</body>

</html>