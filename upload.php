<?php
// Свързване с базата данни
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dmsocial";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error while trying to connect with database: " . $conn->connect_error);
}

// Проверка дали е изпратен формулярът за качване
if (isset($_POST['upload'])) {
    $title = $_POST['title'];
    $type = $_FILES['file']['type'];
    $content = file_get_contents($_FILES['file']['tmp_name']);

    // Подготовка на SQL заявката
    $sql = "INSERT INTO posts (title, type, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $type, $content);

    // Изпълнение на заявката
    if ($stmt->execute()) {
        echo "<p class='sub-heading'>You successfully uploaded the file/s.</p>";
    } else {
        echo "Error while uploading the file: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
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