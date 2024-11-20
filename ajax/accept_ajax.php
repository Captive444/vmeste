<?php
session_start();
require(__DIR__ . '/../includes/db.php');
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['friendId'])) {

    $currentUserId = $_SESSION['id']; 
    $friendId = $data['friendId'];

    $queryCheck = "SELECT * FROM friends WHERE user_id = $currentUserId AND friend_id = $friendId";
    $resultCheck = mysqli_query($link, $queryCheck);

    

    if (!$resultCheck) {
        
        header('Content-Type: application/json', true, 500);
        echo json_encode(['status' => 'error', 'message' => 'Ошибка базы данных']);
        exit;
    }

    if (mysqli_num_rows($resultCheck) > 0) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Запрос уже отправлен']);
        exit; 
    }

$sql = "INSERT INTO friends SET user_id = $currentUserId, friend_id = '$friendId'";
$res = mysqli_query($link, $sql);

    if ($res) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } else {
        header('Content-Type: application/json', true, 500);
        echo json_encode(['success' => false, 'error' => 'Ошибка при добавлении друга']);
    }

} else { 
    
    header('Content-Type: application/json', true, 400);
    echo json_encode(['status' => 'error', 'message' => 'Отсутствует параметр friendId']);
}



?>