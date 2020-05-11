<?php

require_once 'twig_init.php';
require_once 'pdo.php';

session_start();
$_SESSION['hash'] = null;

$login_error_info = array('error' => '');

if (isset($_POST['password'])) {
  if (preg_match(/*'/(?=.*[A-Z])(?=^.{10,12}$)[\!\~\-\.\[\]\{\}\_\^\$\&]{1,2}\w+[\!\~\-\.\[\]\{\}\_\^\$\&]{1,2}/'*/'/.../', $_POST['password']) && isset($_POST['username'])) {
    $user_hash = hash('sha256', $_POST['username'] . $_POST['password']);
    if (is_user_registered($db_shelter, $user_hash)) {
      $_SESSION['hash'] = $user_hash;
      header('Location: http://'.$_SERVER['HTTP_HOST'].'/account.php');
      return;
    }
    else {
      $login_error_info['error'] = 'user is not registered';
    }
  }
  else {
    $login_error_info['error'] = 'low reliable password';
  }
}

echo $twig->render('login.html', array('login_error_info' => $login_error_info));
