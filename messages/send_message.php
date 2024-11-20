<?php
session_start();
require(__DIR__ . '/../includes/db.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['message'])) {
        $user_id = $_SESSION['id'];
        $companionId = $data['companionId'];
        $message = mysqli_real_escape_string($link, $data['message']);
        $sql = "INSERT INTO messages (sender_id, recipient_id, text, timestamp, read_status) 
                VALUES ($user_id, '$companionId', '$message', NOW(), 0)";

        if (mysqli_query($link, $sql)) {
            echo json_encode(['success' => true, 'message' => 'Сообщение отправлено']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ошибка отправки сообщения']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Неверные данные']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Неверный метод запроса']);
}
?>