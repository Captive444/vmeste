
 <?php
session_start();
require 'includes/db.php';

if (isset($_POST['accept'])) {
    $id = $_POST['accept'];
    $sql = "UPDATE `requests` SET `status` = 'accepted' WHERE id = $id";
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
    if ($result) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($link);
    }
    }


?>