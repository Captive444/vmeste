<?php
session_start();
require(__DIR__ . '/../includes/db.php');


if (isset($_SESSION['auth']) and $_SESSION['auth'] === true) {
    $user_id = $_SESSION['id'];

$sql = "SELECT m.*, u.username AS sender_name, u.avatar AS sender_avatar, u.first_name AS sender_first_name, u.last_name AS sender_last_name, u.username AS login
        FROM messages m
        JOIN users u ON m.sender_id = u.id
        WHERE m.recipient_id = $user_id 
        AND m.recipient_id > 0"; 

$res = mysqli_query($link, $sql);

$messages = [];
if (mysqli_num_rows($res) > 0) {
    while ($message = mysqli_fetch_assoc($res)) {
        $messages[] = [
            'user_id' => $message['sender_id'],
            'username' => $message['sender_first_name'],
            'username2' => $message['sender_last_name'],
            'login' => $message['login'],
            'avatar' => $message['sender_avatar'],
            'last_message' => $message['text'],
            'date' => $message['timestamp']
        ];
    }
} 
}

$profile = '';

if (isset($_SESSION['auth']) and $_SESSION['auth'] === true) {
    $user_id = $_SESSION['user_id']; 

    
    $profile .= '<div class="messages-list">'; 
// $profile .= '<h2>Сообщения</h2>';
    foreach ($messages as $message) {
       
        $profileUrl = "/messages" . '/' . $message['login'] . '?id=' . $message['user_id']; 

        $profile .= '<a href="' . $profileUrl . '" class="message-item">';
        $profile .= '<img src="' . $message['avatar'] . '" alt="' . $message['username'] . '" class="avatar">';
        $profile .= '<div class="message-info">';
        $profile .= '<span class="username">' . $message['username'] . ' ' . $message['username2'] . '</span>';
        $profile .= '<p class="last-message">' . $message['last_message'] . '</p>';
        $profile .= '</div>';
        $profile .= '<span class="message-date">' . $message['date'] . '</span>';
        $profile .= '</a>';
    }

    $profile .= '</div>'; 
}

$page = [
    'title' => 'Сообщения',
    'content' => $profile
];

return $page;

?>