<?php 
session_start();
require(__DIR__ . '/../includes/db.php');


if (isset($_SESSION['auth']) and $_SESSION['auth'] === true) {

    $data = json_decode(file_get_contents('php://input'), true);


    $author_id = $data['author_id'];
    $text = mysqli_real_escape_string($link, $data['text']);
    $image = $data['image'];
    $receiver_id = $data['receiver_id'];

   
      if (!empty($image)) { 

        $image_data = file_get_contents($image); 
    } else {
        $image_data = null; 
    }

    $sql = "INSERT INTO posts (author_id, receiver_id, text, timestamp, image) VALUES ($author_id, $receiver_id, '$text', NOW(), '$image_data')";

    if (mysqli_query($link, $sql)) {
    
        echo json_encode(['success' => true]); 
    } else {
    
        echo json_encode(['success' => false, 'error' => mysqli_error($link)]);
    }
}

?>