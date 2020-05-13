<?php

require_once 'twig_init.php';
require_once 'pdo.php';

session_start();

if ($_SESSION['hash'] == null) {
  header('Location: http://'.$_SERVER['HTTP_HOST'].'/login.php');
  return;
}

if ($_SESSION['user_status'] == 'admin') {
    $twig -> addGlobal('user_status', $_SESSION['user_status']);
    $twig -> addGlobal('account_photo', $_SESSION['account_photo']);
    $twig -> addGlobal('signed_in', true);
}
else {
    $account = get_user_account($db_shelter, $_SESSION['hash']);
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/account.php?acc_id='.$account['user_id']);
    return;
}

if ($_POST['title'] != '' && $_POST['text'] != '' && $_POST['image'] != '') {
  $account = get_user_account($db_shelter, $_SESSION['hash']);
  date_default_timezone_set('Europe/Minsk');
  $timestamp = date("Y-m-d H:i:s");
  $res_publ_id = add_publication($db_shelter, array('author_id' => $account['user_id'], 'timestamp' => $timestamp, 'title' => $_POST['title'], 'text' => $_POST['text'], 'image' => $_POST['image'], 'like_amount' => 0));
  header('Location: http://'.$_SERVER['HTTP_HOST'].'/publication.php?publ_id='.$res_publ_id);
}

echo $twig->render('creator.html', array());
