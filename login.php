<?php

require_once 'twig_init.php';
require_once 'pdo.php';

session_start();
$_SESSION['hash'] = null;

$login_error_info = '';

if (isset($_POST['password']) && isset($_POST['username'])) {
    $user_hash = hash('sha256', $_POST['username'] . $_POST['password']);
    if (is_user_registered($db_shelter, $user_hash)) {
      $_SESSION['hash'] = $user_hash;
      header('Location: http://'.$_SERVER['HTTP_HOST'].'/account.php');
      return;
    }
    else {
      $login_error_info = 'user is not registered';
    }
}

echo $twig->render('login.html', array('login_error_info' => $login_error_info));
