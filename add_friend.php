<?php
session_start();
require 'includes/db.php';
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['friendId'])  && isset($_SESSION['auth']) && $_SESSION['auth'] === true) {

    $currentUserId = $_SESSION['id'];
    $friendId = $data['friendId'];

        $queryCheck = "SELECT * FROM friend_requests WHERE sender_id = $currentUserId AND receiver_id = $friendId";
        $resultCheck = mysqli_query($link, $queryCheck) or die(json_encode(['status' => 'error', 'message' => 'Ошибка базы данных']));
        if (mysqli_num_rows($resultCheck) > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Запрос уже отправлен']);
            exit;
        }

    $query = "INSERT INTO friend_requests (sender_id, receiver_id) VALUES ($currentUserId, $friendId)";
    $res = mysqli_query($link, $query);


   if ($res) {
 
       header('Content-Type: application/json');
       echo json_encode(['success' => true]);
   } else {
     
       header('Content-Type: application/json', true, 500); 
       echo json_encode(['success' => false, 'error' => 'Ошибка при добавлении друга']); 
   }

}



?>
