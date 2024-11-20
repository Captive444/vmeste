
<?php 
 session_start();
require 'includes/db.php';

if (!$link) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

$profile = '';

if (isset($_SESSION['auth']) and $_SESSION['auth'] === true) {
    $login = $_SESSION['login'];
    $user_id = $_SESSION['id'];

    if ($_SERVER['REQUEST_URI'] === '/friends') {
        $queryFriends = "SELECT u.id, u.username, u.first_name, u.last_name, u.avatar FROM users u INNER JOIN friends f ON u.id = f.friend_id OR u.id = f.user_id WHERE (f.user_id = $user_id AND u.id != $user_id) OR (f.friend_id = $user_id AND u.id != $user_id)";
        $resultFriends = mysqli_query($link, $queryFriends) or die("Ошибка " . mysqli_error($link));

        $profile .= '<main class="main-content">';
        $profile .= '<section class="friends-list"><h3>Друзья</h3>';

        if (mysqli_num_rows($resultFriends) > 0) {
            $profile .= '<ul>';
            while ($friend = mysqli_fetch_assoc($resultFriends)) {
                $profile .= '
                    <li>
                        <a href="friend?id=' . $friend['id'] . '">
                            <img src="' . $friend['avatar'] . '" alt="Фото профиля ' . $friend['username'] . '">
                            <span>' . $friend['first_name'] . ' ' . $friend['last_name'] . '</span>
                        </a>
                    </li>
                ';
            }
            $profile .= '</ul>';

            
            

            
        } else {
            $profile .= '<p>У вас пока нет друзей.</p>';
        }
        /// запрос на дружбу


        $sql = "SELECT u.id AS id, f.sender_id AS sender, f.receiver_id AS receiver, u.first_name AS name, u.last_name FROM friend_requests f LEFT JOIN users u ON f.sender_id = u.id WHERE f.receiver_id = $user_id";
        //  $sql = "SELECT u.id AS id, f.user_id AS sender, f.friend_id AS receiver, u.first_name AS name, u.last_name FROM friends f LEFT JOIN users u ON f.friend_id = u.id WHERE user_id = $user_id OR friend_id = $user_id";
        $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
        $profile.= '<section class="friends-list"><h3>Запросы на дружбу</h3>';


if (mysqli_num_rows($result) > 0) {
    $profile .= '<ul>';
    while ($row = mysqli_fetch_assoc($result)) {
        $profile .= '
            <li>
                <a href="friend?id=' . $row['id'] . '" class="friend-request">
                    <img src="' . $row['avatar'] . '" alt="Фото профиля ' . $row['username'] . '">
                    <span>' . $row['name'] . ' ' . $row['last_name'] . '</span>'
                .  '</a>'
                    . ' <div class="buttons">';

              

                if ($row['receiver'] == $user_id or $row['sender'] == $user_id) {
    $profile .= '<button type="button" class="accept btn btn-success add-friend-button" data-friend-id="' . $row['sender'] . '" data-username="' . $row['name'] . '">Принять</button>';
    $profile .= '<button type="button" class="decline btn btn-danger delete-friend-button" data-friend-id="' . $row['sender'] . '" data-username="' . $row['name'] . '">Отклонить</button>';
}

                $profile .= '</div>
               
            </li>
        ';
    }
    $profile .= '</ul>';
}                    
        
        
        else {
            $profile .= '<p>У вас нет запросов на дружбу.</p>';
        }

        $profile .= '</section>';
        $profile .= '</main>'; 
    } 
}

$page = [
    'title' => 'Друзья',
    'content' => $profile
];

return $page;
   
   ?>
  