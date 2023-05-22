<?php
require_once 'session.php';

// Функция за извличане на коментарите за дадена публикация
function getComments($postId, $conn) {
    $sql = "SELECT comment_content, username FROM comments WHERE post_id = $postId";
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

// Функция за определяне на текста на бутона за харесване
function getLikeButtonText($postId, $userId, $conn) {
    $sql = "SELECT id FROM likes WHERE post_id = $postId AND user_id = '$userId'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return 'Unlike';
    } else {
        return 'Like';
    }
}

function getLikeButtonAction($postId, $userId, $conn) {
    $sql = "SELECT id FROM likes WHERE post_id = $postId AND user_id = '$userId'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return 'unlike';
    } else {
        return 'like';
    }
}

// Връзка с базата данни
$conn = mysqli_connect("localhost", "root", "", "dmsocial");

// Проверка за успешна връзка с базата данни
if (!$conn) {
    die("Error in database connection: " . mysqli_connect_error());
}

// Извличане на публикациите, заглавията и потребителските имена
$sql = "SELECT p.id, p.title, p.content, p.likes, u.username
        FROM posts p
        LEFT JOIN users u ON p.user_id = u.id";

$result = mysqli_query($conn, $sql);

$posts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $postId = $row['id'];

    $posts[$postId] = [
        'id' => $postId,
        'title' => $row['title'],
        'content' => $row['content'],
        'likes' => $row['likes'],
        'username' => $row['username'],
        'comments' => getComments($postId, $conn),
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Система за харесвания</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .post {
            margin-bottom: 20px;
        }
        img {
            width: 300px;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Логика за обработка на щракване на бутона "Like" или "Unlike"
            $('.like-btn').click(function() {
                var postId = $(this).data('post-id');
                var userId = $(this).data('user-id');
                var action = $(this).data('action');

                var likeButton = $(this);
                var likeCount = $(this).siblings('.like-count');

                $.ajax({
                    url: 'like.php',
                    method: 'POST',
                    data: {
                        post_id: postId,
                        user_id: userId,
                        action: action
                    },
                    success: function(response) {
                        if (response.success) {
                            likeButton.text(response.buttonText);
                            likeCount.text(response.likeCount);
                        } else {
                            console.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            // Логика за обработка на подаване на формата за коментар
            $('.comment-form').submit(function(event) {
                event.preventDefault();

                var postId = $(this).find('input[name="post_id"]').val();
                var commentContent = $(this).find('textarea[name="comment_content"]').val();
                var userId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;

                $.ajax({
                    url: 'comment.php',
                    method: 'POST',
                    data: {
                        post_id: postId,
                        comment_content: commentContent,
                        user_id: userId
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log(response.message);
                            // Опресняване на страницата или изпълнение на допълнителна логика
                        } else {
                            console.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
</head>
<body>
<?php foreach ($posts as $post): ?>
    <?php
        $postId = $post['id'];
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        // Определяне на текста и действието на бутона за харесване
        $likeButtonText = getLikeButtonText($postId, $userId, $conn);
        $likeButtonAction = getLikeButtonAction($postId, $userId, $conn);
    ?>

    <div class="post">
        <h3>Uploaded by: <?php echo $post['username']; ?></h3>
        <p><?php echo $post['title']; ?></p>
        <img src="data:content/jpeg;base64,<?php echo base64_encode($post['content']); ?>" />

        <div>
            <button class="like-btn" data-post-id="<?php echo $postId; ?>" data-user-id="<?php echo $userId; ?>" data-action="<?php echo $likeButtonAction; ?>">
                <?php echo $likeButtonText; ?>
            </button>
            <span class="like-count"><?php echo $post['likes']; ?></span> Likes
        </div>

        <div>
            <h4>Comments:</h4>
            <?php foreach ($post['comments'] as $comment): ?>
                <p><?php echo $comment['content']; ?> (by <?php echo $comment['username']; ?>)</p>
            <?php endforeach; ?>
        </div>

        <form class="comment-form" action="comment.php" method="POST">
            <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
            <textarea name="comment_content" rows="4" cols="50" required></textarea><br>
            <input type="submit" value="Submit Comment">
        </form>
    </div>
<?php endforeach; ?>

</body>
</html>
