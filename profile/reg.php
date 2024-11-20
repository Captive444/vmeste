<?php
    require 'includes/db.php';
    session_start();

   $content = ''; 

	if (!empty($_POST['login']) and !empty($_POST['password'])  and !empty($_POST['firstname']) and !empty($_POST['lastname']) and !empty($_POST['birthdate']) and !empty($_POST['email']) and !empty($_POST['city'])) {
		$login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		
		$query = "INSERT INTO users SET username='$login', password_hash='$password',  email='$_POST[email]', first_name='$_POST[firstname]', last_name='$_POST[lastname]', birthdate='$_POST[birthdate]', city='$_POST[city]', about_me='$_POST[about_me]', registration_date=NOW()";
		mysqli_query($link, $query) or die('Error: ' . mysqli_error($link));

        $_SESSION['auth'] = true;
        $_SESSION['login'] = $login;
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['firstname'] = $_POST['firstname'];
        $_SESSION['lastname'] = $_POST['lastname'];
        $_SESSION['birthdate'] = $_POST['birthdate'];
        $_SESSION['city'] = $_POST['city'];
        $_SESSION['about_me'] = $_POST['about_me'];
        $_SESSION['registration_date'] = date('Y-m-d H:i:s');
        
        
        $id = mysqli_insert_id($link);
        $_SESSION['id'] = $id;
         header("Location:  /$login");
        die();
	}
    else {

$content .= ' 
 <form action="" method="POST" class="formLog">
        <h1>Регистрация</h1>
        <label for="login">Логин:</label>
        <input type="text" name="login">
        <label for="password">Пароль:</label>
        <input type="password" name="password">
        <label for="firstname">Имя:</label>
        <input type="text" name="firstname">
        <label for="lastname">Фамилия:</label>
        <input type="text" name="lastname">
        <label for="birthdate">Дата рождения:</label>
        <input type="date" name="birthdate">
        <label for="city">Город:</label>
        <input type="text" name="city">
        <label for="email">Email:</label>
        <input type="email" name="email">
        <label for="about_me">О себе:</label>
        <textarea name="about_me"></textarea>
        <input type="submit" value="Зарегистрироваться">
    </form>';
    }




$page = [
    'title' => 'Регистрация',
    'content' => $content
];

return $page;
?>




