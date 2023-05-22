<?php
session_start();

if (isset($_POST['post_id']) && isset($_POST['user_id']) && isset($_POST['action'])) {
    // Вземете стойностите на post_id, user_id и action от заявката
    $postId = $_POST['post_id'];
    $userId = $_POST['user_id'];
    $action = $_POST['action'];

    // Връзка с базата данни
    $conn = mysqli_connect("localhost", "root", "", "dmsocial");

    // Проверка за успешна връзка с базата данни
    if (!$conn) {
        die("Error in database connection: " . mysqli_connect_error());
    }

    // Проверка на действието (like или unlike)
    if ($action == 'like') {
        // Проверка дали потребителят вече е харесал публикацията
        $sql = "SELECT id FROM likes WHERE post_id = $postId AND user_id = '$userId'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            // Актуализиране на броя на харесванията в таблицата "posts"
            $sql = "UPDATE posts SET likes = likes + 1 WHERE id = $postId";
            mysqli_query($conn, $sql);

            // Вмъкване на запис в таблицата "likes"
            $sql = "INSERT INTO likes (post_id, user_id) VALUES ($postId, '$userId')";
            mysqli_query($conn, $sql);

            // Информиране за успешното харесване
            $response = array(
                "success" => true,
                "message" => "Post liked successfully",
                "buttonText" => "Unlike"
            );
        } else {
            // Вече е харесана публикацията от потребителя
            $response = array(
                "success" => false,
                "message" => "Post already liked by the user",
                "buttonText" => "Unlike"
            );
        }
    } elseif ($action == 'unlike') {
        // Проверка дали потребителят вече е харесал публикацията
        $sql = "SELECT id FROM likes WHERE post_id = $postId AND user_id = '$userId'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // Актуализиране на броя на харесванията в таблицата "posts"
            $sql = "UPDATE posts SET likes = likes - 1 WHERE id = $postId";
            mysqli_query($conn, $sql);

            // Изтриване на записа от таблицата "likes"
            $sql = "DELETE FROM likes WHERE post_id = $postId AND user_id = '$userId'";
            mysqli_query($conn, $sql);

            // Информиране за успешното премахване на харесването
            $response = array(
                "success" => true,
                "message" => "Post unliked successfully",
                "buttonText" => "Like"
            );
        } else {
            // Публикацията не е харесана от потребителя
            $response = array(
                "success" => false,
                "message" => "Post not liked by the user",
                "buttonText" => "Like"
            );
        }
    }

    // Затваряне на връзката с базата данни
    mysqli_close($conn);

    // Връщане на отговора в JSON формат
    header("Content-type: application/json");
    echo json_encode($response);
}
?>
