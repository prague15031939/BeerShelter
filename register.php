<?php

require_once 'twig_init.php';
require_once 'pdo.php';

session_start();
$_SESSION['hash'] = null;

$register_error_info = '';

if (isset($_POST['password']) && isset($_POST['username']) && isset($_POST['email'])) {
  if (preg_match(/*'/^(?=.*[A-Z])(?=^.{10,12}$)[\!\~\-\.\[\]\{\}\_\^\$\&]{1,2}\w+[\!\~\-\.\[\]\{\}\_\^\$\&]{1,2}$/'*/'/^...$/', $_POST['password'])) {
    $user_hash = hash('sha256', $_POST['username'] . $_POST['password']);
    if (is_user_unique($db_shelter, $_POST['username'], $user_hash)) {
      register_user($db_shelter, $_POST['username'], $_POST['email'], 'images/default_avatar.png', $user_hash);
      $_SESSION['hash'] = $user_hash;
      header('Location: http://'.$_SERVER['HTTP_HOST'].'/account.php');
      return;
    }
    else {
      $register_error_info = 'user is already registered';
    }
  }
  else {
    $register_error_info = 'unreliable password';
  }
}

echo $twig->render('register.html', array('register_error_info' => $register_error_info));
