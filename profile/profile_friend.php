<?php
session_start();
require 'includes/db.php';
require 'func/func.php';


$id = $_GET['id'];
$_SESSION['receiver_id'] = $id;

  $profile = '';



   $query = "SELECT * FROM users WHERE id = $id";
       $result = mysqli_query($link, $query);

       if ($user = mysqli_fetch_assoc($result)) {
 $profile .= '
    <div class="container">
        <div class="profile-header">
            <img src="' . $user['avatar'] . '" alt="Фото профиля" class="profile-picture">
            <h2>' . $user['first_name'] . ' ' . $user['last_name'] . '</h2>';
            
    $isFriend = false;
    if (isset($_SESSION['auth']) and $_SESSION['auth'] === true) {
        $currentUserId = $_SESSION['id'];
        $queryFriends = "SELECT * FROM friends WHERE (user_id = $currentUserId AND friend_id = $id) OR (user_id = $id AND friend_id = $currentUserId)";
        $resultFriends = mysqli_query($link, $queryFriends);
        if (mysqli_num_rows($resultFriends) > 0) {
            $isFriend = true;
        }
    }

$posts = getPosts($link, $currentUserId, $id);


    if ($isFriend) {
        $profile .= '<button type="button" class="btn btn-secondary" disabled>В друзьях</button> <button type="button" class="btn btn-danger remove-friend-button" data-friend-id="' . $id . '">Удалить из друзей</button>';
       $profile .= '<a href="/messages/' . $user['username'] . '?id=' . $user['id'] . '">Отправить Сообщения</a>';

    } else {
     $profile .= '<button type="button" class="btn btn-primary add-friends-button" data-friend-id="' . $id . '" data-user-id="' . $_SESSION['id'] . '">Добавить в друзья</button>';
    } 
   $profile .= '
        </div>
        <div class="content">
            <aside class="sidebar">
                <ul>
                    <li><a href="' . $_SESSION['login'] . '">Моя страница</a></li>
                    <li><a href="/news">Новости</a></li>
                    <li><a href="/messages">Сообщения</a></li>
                    <li><a href="/friends">Друзья</a></li>
                    <li><a href="/groups">Группы</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <section class="user-info">
                    <h3>Информация о пользователе <a href="' . $user['login'] . '">' . $user['first_name'] . ' ' . $user['last_name'] . '</a></h3>
                    <p><strong>Дата рождения:</strong> ' . $user['birthdate'] . '</p>
                    <p><strong>Город:</strong> ' . $user['city'] . '</p>
                    <p><strong>О себе:</strong> ' . $user['about_me'] . '</p> 
                    <!-- Добавьте другие поля информации о пользователе --> 
                </section>

                <section class="wall">
                    <h3>Стена</h3>
                    <div class="post-form">
                        <form action="" method="POST" enctype="multipart/form-data"> 
                            <input type="hidden" name="receiver_id" value="' . $id . '">
                            <textarea name="text" placeholder="Написать сообщение..."></textarea>
                            <input type="hidden" name="user_id" value="' . $currentUserId . '">
                            <input type="file" name="image" accept="image/*"> 
                            <button type="submit">Опубликовать</button>
                        </form>
                    </div>

                     <div class="wall-posts">' . $posts . ' </div>';

    $profile .= '</div> </section>
    
            </main>
        </div>
    </div>';
    
       } 
  
$page = [
    'title' => 'Профиль',
    'content' =>  $profile
];

return $page;

   ?>