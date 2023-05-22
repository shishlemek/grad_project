<?php
// Проверка дали формата за влизане е изпратена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Вземане на данните от формата
    $email = $_POST['email'];
    $password = $_POST['password'];

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

    // Подготовка на заявката за избор на потребител със съответното потребителско име и парола
    $query = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $email, $password);
    mysqli_stmt_execute($stmt);

    // Изпълнение на заявката и получаване на резултатите
    $result = mysqli_stmt_get_result($stmt);

    // Проверка за наличие на потребител в базата със зададеното потребителско име и парола
    if (mysqli_num_rows($result) === 1) {
        echo "Успешно влизане в акаунта.";
    } else {
        echo "Невалидно потребителско име или парола.";
    }

    // Затваряне на връзката с базата данни
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
