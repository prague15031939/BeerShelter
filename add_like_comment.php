<?php

require_once 'pdo.php';

session_start();

if ($_SESSION['hash'] != null) {
  if ($_POST['comment_text'] != '') {
    $account = get_user_account($db_shelter, $_SESSION['hash']);
    date_default_timezone_set('Europe/Minsk');
    $timestamp = date("Y-m-d H:i:s");
    add_comment($db_shelter, array('author_id' => $account['user_id'], 'timestamp' => $timestamp, 're_publ_id' => $_GET['publ_id'], 'text' => $_POST['comment_text']));
  }
}

header('Location: http://'.$_SERVER['HTTP_HOST'].'/publication.php?publ_id='.$_GET['publ_id']);
