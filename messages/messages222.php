<?php
session_start();
require(__DIR__ . '/../includes/db.php');

if (isset($_SESSION['auth']) and $_SESSION['auth'] === true) {
    $user_id = $_SESSION['id']; 

    
    $companion_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $_SESSION['companion_id'] = $companion_id;

    if (isset($_SESSION['companion_id']) && $_SESSION['companion_id'] != 0) {
            $companion_id = $_SESSION['companion_id'];
        } else {
          
            $companion_id = get_companion_id_from_somewhere(); 
            $_SESSION['companion_id'] = $companion_id; 
        }

function generate_message_html($messages, $user_id) {
    $html = '';
    foreach ($messages as $message) {
        $messageClass = ($message['sender_id'] == $user_id) ? 'message-sent' : 'message-received';
        $html .= '<div class="message ' . $messageClass . '">
                    <img src="' . $message['sender_avatar'] . '" alt="' . $message['sender_name'] . '" class="avatar">
                    <div class="message-content">
                        <p>' . $message['text'] . '</p>
                    </div>
                  </div>';
    }
    return $html;
}


    if ($companion_id > 0) {

        $sql = "SELECT m.*, s.first_name AS sender_name, s.last_name AS sender_last_name, s.avatar AS sender_avatar FROM messages m JOIN users s ON m.sender_id = s.id WHERE (m.sender_id = $user_id AND m.recipient_id = $companion_id) OR (m.sender_id = $companion_id AND m.recipient_id = $user_id) ORDER BY m.timestamp ASC";


        $res = mysqli_query($link, $sql);

        $messages = [];
        while ($message = mysqli_fetch_assoc($res)) {
            $messages[] = $message;
        }

    $page = [
        'title' => 'Диалог',
        'content' => '
         <div class="dialog-wrapper"> 
            <h2>Диалог</h2>
            <div class="chat-container" data-companion-id="' . $companion_id . '">
                <div class="messages-list">
                    ' . generate_message_html($messages, $user_id) . ' 
                </div>
                <div class="message-form" data-companion-id="' . $companion_id . '"> 
                    <textarea placeholder="Введите сообщение..."></textarea>
                    <button type="button" class="send-message-btn">Отправить</button>
                </div>
                  </div>
            </div>',
    ];
var_dump($companion_id);
        
    } else {
        $page = [
            'title' => 'Ошибка',
            'content' => 'Выберите собеседника',
        ];
    }


} 

return $page;

?>