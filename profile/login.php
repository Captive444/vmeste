
<?php
session_start();
require 'includes/db.php';

$content = '';
if (!empty($_POST['password']) && !empty($_POST['login'])) {

    $login = $_POST['login']; 

    $query = "SELECT * FROM users WHERE username='$login'"; 
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $user = mysqli_fetch_assoc($res);

  
    if (!empty($user)) { 
        $hash = $user['password_hash'];

  
        if (password_verify($_POST['password'], $hash)) { 
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $login;
            // $_SESSION['role'] = $user['role'];
            $_SESSION['id'] = $user['id'];
            header("Location:  /$login");
            die();
        } else {
            $_SESSION['auth'] = false;
            echo "Неверный пароль<br>"; 
        }
    } else { 
        echo "Пользователь с таким логином не найден<br>"; 
    }
} 
$content .= '
    <form action="" method="POST" class="formLog">
        <h2>Вход</h2>
        <label for="login">Логин</label>
        <input name="login" type="text" placeholder="Логин"> 
        <label for="password">Пароль</label> 
        <input name="password" type="password" placeholder="Пароль">  
        <input type="submit" value="Вход">  
    </form>
';



$page = [
    'title' => 'Вход',
    'content' => $content 
];

return $page;
?>






