<?php
// Проверка дали формата за регистрация е изпратена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Вземане на данните от формата
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Извършване на валидация на данните (можете да добавите допълнителна валидация според нуждите си)

    // Връзка с базата данни
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "dmsocial";

    $conn = mysqli_connect($servername, $username_db, $password_db, $dbname);

    // Проверка за успешно свързване
    if (!$conn) {
        die("Error while connecting with db: " . mysqli_connect_error());
    }

        // Подготовка на заявката за вмъкване на данните в базата
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $password);
        
        // Изпълнение на заявката
        if (mysqli_stmt_execute($stmt)) {
            echo "Your registration is successful.";
        } else {
            echo "Check again your password, email or username: " . mysqli_error($conn);
        }
        
        // Затваряне на връзката с базата данни
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    ?>
  <!DOCTYPE html>
<html>

<head>
    <title>DMSocial</title>
    <link rel="stylesheet" href="style.css">
</head>  
        <nav class="navbar">
        <img src="img/logo.png" class="logo" alt="">
        <ul class="links-container">
            <li class="link-item"><a href="home.html" class="link">home</a></li>
            <li class="link-item"><a href="index.php" class="link">post</a></li>
            <li class="link-item"><a href="post_page.php" class="link">View Posts</a></li>
        </ul>
    </nav>
    </body>

</html>