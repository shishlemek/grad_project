<!DOCTYPE html>
<html>
<head>
    <title>Махане на линк от навигация след регистрация</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Начало</a></li>
            <?php
                session_start();

                // Проверка дали потребителят е регистриран
                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
                    // Потребителят е регистриран, не показваме линка
                } else {
                    // Потребителят не е регистриран, показваме линка
                    echo '<li><a href="register.php">Регистрация</a></li>';
                }
            ?>
            <li><a href="about.php">За нас</a></li>
        </ul>
    </nav>

    <!-- Останалата част на страницата -->

    <?php
        // Тук има код за регистрацията на потребителя
        // ...

        // След успешна регистрация, отбелязваме потребителя като регистриран
        $_SESSION['logged_in'] = true;
    ?>

</body>
</html>
