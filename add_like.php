<?php

require_once 'pdo.php';

session_start();

if ($_SESSION['hash'] != null) {
  $account = get_user_account($db_shelter, $_SESSION['hash']);
  correct_like($db_shelter, $account['user_id'], $_GET['publ_id']);
}

header('Location: http://'.$_SERVER['HTTP_HOST'].'/publication.php?publ_id='.$_GET['publ_id']);
