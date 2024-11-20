<?php
session_start();
require(__DIR__ . '/../includes/db.php');


if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {

    $user_id = $_SESSION['id'];

    $sql = "SELECT * FROM posts WHERE author_id = $user_id ORDER BY timestamp DESC";
    $result = mysqli_query($link, $sql);

    $posts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['image'] = base64_encode($row['image']); 
        $posts[] = $row;
    }

    echo json_encode($posts); 

} 
// else {
//     header('Location: /login.php'); 
//     exit();
// }
?>