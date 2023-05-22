<?php
require_once 'session.php';

// Връзка с базата данни
$conn = mysqli_connect("localhost", "root", "", "dmsocial");

// Проверка за успешна връзка с базата данни
if (!$conn) {
    die("Error in database connection: " . mysqli_connect_error());
}

// Проверка за изпращане на POST заявка
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка за наличие на данни в POST заявката
    if (isset($_POST['post_id'], $_POST['comment_content'], $_POST['user_id'])) {
        $postId = $_POST['post_id'];
        $commentContent = $_POST['comment_content'];
        $userId = $_POST['user_id'];

        // Вмъкване на коментара в базата данни
        $sql = "INSERT INTO comments (post_id, comment_content, user_id) VALUES ('$postId', '$commentContent', '$userId')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $commentId = mysqli_insert_id($conn);
            $username = getUsername($userId, $conn);

            // Отговор с успешно добавения коментар
            $response = array(
                "success" => true,
                "message" => "Comment added successfully",
                "comment" => array(
                    "id" => $commentId,
                    "content" => $commentContent,
                    "username" => $username
                )
            );
        } else {
            // Грешка при добавяне на коментара
            $response = array(
                "success" => false,
                "message" => "Error adding comment"
            );
        }
    } else {
        // Липсващи данни в заявката
        $response = array(
            "success" => false,
            "message" => "Missing data in request"
        );
    }
} else {
    // Невалиден метод на заявка
    $response = array(
        "success" => false,
        "message" => "Invalid request method"
    );
}

// Извличане на коментарите за съответната публикация
function getComments($postId, $conn) {
    $sql = "SELECT comments.comment_content, users.username FROM comments INNER JOIN users ON comments.user_id = users.id WHERE comments.post_id = $postId";
    $result = mysqli_query($conn, $sql);
    $comments = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = [
            'content' => $row['comment_content'],
            'username' => $row['username'],
        ];
    }
    return $comments;
}

// Връщане на коментарите в JSON формат
if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];
    $comments = getComments($postId, $conn);
    $response['comments'] = $comments;
}

// Затваряне на връзката с базата данни
mysqli_close($conn);

// Връщане на отговора в JSON формат
header("Content-type: application/json");
echo json_encode($response);
?>
