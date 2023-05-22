<?php
// db conn
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dmsocial";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Проверка за успешно свързване
if (!$conn) {
    die("Error while connecting with db: " . mysqli_connect_error());
}

// Проверка дали е изпратен имейл адрес
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Проверка дали имейл адресът съществува в базата данни
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        // Генериране на уникален код за смяна на паролата
        $resetCode = uniqid();

        // Записване на кода в базата данни
        $query = "UPDATE users SET reset_code = ? WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $resetCode, $email);
        mysqli_stmt_execute($stmt);

        // Изпращане на имейл с връзка за смяна на паролата
        $resetLink = "http://example.com/reset_password.php?code=" . $resetCode;

        // Изпращане на имейл
        $to = $email;
        $subject = "Password change";
        $message = "To change your password go to this link: " . $resetLink;
        $headers = "From: admin@example.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "The email with the instructions is sent.";
        } else {
            echo "Error in sending email.";
        }
    } else {
        echo "Error in email address.";
    }

    mysqli_stmt_close($stmt);
}

// closing db conn
mysqli_close($conn);
?>
