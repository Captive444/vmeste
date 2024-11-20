<?php
session_start();
require 'includes/db.php';


$url = $_SERVER['REQUEST_URI'];


switch (true) {
    case ($url == '/'):
        $page = include 'all.php';
        break;
    case ($url == '/register'):
        $page = include 'profile/reg.php';
        break;
    case ($url == '/login'):
        $page = include 'profile/login.php';
        break;
             case ($url == '/friends'):
        $page = include 'profile/friends.php';
        break;    
case (preg_match('#^/(?<login>[a-zA-Z0-9_-]+)$#', $url, $params)):
    if ($params['login'] === $_SESSION['login'] ) {
    $page = include 'profile/profile.php';
    }
    break;
    case ($url == '/logout'):
        $page = include 'profile/logout.php';
        break;
    case ($url == '/search.php'):
        $page = include 'search.php';
        break;
   case (substr($url, 0, -1) === '/messages'):
        $page = include 'messages/messages.php';
        break;
    case(preg_match('#^/friend(\?.*)?$#', $url)):
        $page = include 'profile/profile_friend.php';
        break;
    case (preg_match('#^/messages/(?<login>[a-zA-Z0-9_-]+)(?:\?.*)?$#', $url)):
        $page = include 'messages/messages222.php';
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        require_once 'includes/404.php';
        break;
}



$layout = file_get_contents('layout.php');
if ($layout === false) {
    die('Не удалось прочитать файл layout.php');
}


$layout = str_replace('{{ title }}', $page['title'], $layout);
$layout = str_replace('{{ content }}', $page['content'], $layout);


echo $layout;
?>
