
<?php
session_start();
require(__DIR__ . '/../includes/db.php');
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['friendId'])  && isset($_SESSION['auth']) && $_SESSION['auth'] === true) {

    $currentUserId = $_SESSION['id']; 
    $friendId = $data['friendId'];


$sql = "DELETE FROM friend_requests f WHERE f.sender_id = $friendId AND f.receiver_id = $currentUserId";
$res = mysqli_query($link, $sql) or die(mysqli . mysqli_error($link));


    if ($res) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } else {
        header('Content-Type: application/json', true, 500);
        echo json_encode(['success' => false, 'error' => 'Ошибка при удалении друга']);
    }


}


?>