<?php
session_start();
require(__DIR__ . '/../includes/db.php');
function getPosts($link, $currentUserId, $receiverId) {

    $sql = "SELECT p.*, u.first_name, u.last_name FROM posts p
            JOIN users u ON p.author_id = u.id
            WHERE p.receiver_id = $receiverId 
            ORDER BY p.timestamp DESC";
    $result = mysqli_query($link, $sql);

    $postsHtml = '';

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
     
            $postHtml = '<div class="post-block">
                            <h4>' . $row['first_name'] . ' ' . $row['last_name'] . '</h4>
                            <p>' . $row['text'] . '</p>';

            if (!empty($row['image'])) {
                $postHtml .= '<img src="assets/' . $row['image'] . '" alt="Изображение поста">';
            }

            $postHtml .= '</div>';

            $postsHtml .= $postHtml;
        }
    } else {
        $postsHtml = '<p>Еще нет постов.</p>';
    }

    return $postsHtml;
}
?>
