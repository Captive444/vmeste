<?php 
require 'includes/db.php';
require 'func/func.php';
   session_start(); 

   
   $profile = '';

   if (isset($_SESSION['auth']) and $_SESSION['auth'] === true) {
       $login = $_SESSION['login'];


      
     
       $query = "SELECT * FROM users WHERE username = '$login'";
       $result = mysqli_query($link, $query);

       if ($user = mysqli_fetch_assoc($result)) {
        $id = $user['id'];
        $posts = getPosts($link, $currentUserId, $id);
 $profile .= '
    <div class="container">
        <div class="profile-header">
            <img src="' . $user['avatar'] . '" alt="Фото профиля" class="profile-picture">
            <h2>' . $user['first_name'] . ' ' . $user['last_name'] . '</h2> 
        </div>
        <div class="content">
            <aside class="sidebar">
                <ul>
                    <li><a href="/profile/' . $user['id'] . '">Моя страница</a></li>
                    <li><a href="/news">Новости</a></li>
                    <li><a href="/messages">Сообщения</a></li>
                    <li><a href="/friends">Друзья</a></li>
                    <li><a href="/groups">Группы</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <section class="user-info">
                    <h3>Информация</h3>
                    <p><strong>Дата рождения:</strong> ' . $user['birthdate'] . '</p>
                    <p><strong>Город:</strong> ' . $user['city'] . '</p>
                    <p><strong>О себе:</strong> ' . $user['about_me'] . '</p> 
                    <!-- Добавьте другие поля информации о пользователе --> 
                </section>

                <section class="wall">
                    <h3>Стена</h3>
                    <div class="post-form">
                      <form action="" method="POST" enctype="multipart/form-data"> 
                            <input type="hidden" name="receiver_id" value="' . $user['id'] . '">
                            <textarea name="text" placeholder="Написать сообщение..."></textarea>
                            <input type="hidden" name="user_id" value="' . $user['id'] . '">
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

   }
$page = [
    'title' => 'Профиль' . ' ' . $login,
    'content' =>  $profile
];

return $page;
   ?>

   
  