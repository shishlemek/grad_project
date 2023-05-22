<?php
session_start();

// Връзка с базата данни
$conn = mysqli_connect("localhost", "root", "", "dmsocial");

// Проверка за успешна връзка с базата данни
if (!$conn) {
    die("Error in database connection: " . mysqli_connect_error());
}

// Извличане на идентификатора на текущия потребител
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    $userId = null;
}

// Затваряне на връзката с базата данни
mysqli_close($conn);
?>
