<?php

require_once 'twig_init.php';
require_once 'pdo.php';

session_start();

if ($_SESSION['hash'] != null) {
  $account = get_user_account($db_shelter, $_SESSION['hash']);
  $_SESSION['user_status'] = $account['status'];
  $_SESSION['account_photo'] = $account['image'];

  $twig -> addGlobal('account_photo', $_SESSION['account_photo']);
  $twig -> addGlobal('signed_in', true);
  $twig -> addGlobal('user_status', $_SESSION['user_status']);
}
else {
    $twig -> addGlobal('signed_in', false);
}

if ($_SESSION['hash'] != null || count($_GET) > 0) {
    if (count($_GET) > 0) {
      $account = get_user_account_by_id($db_shelter, $_GET['acc_id']);
    }
    $user_publications = get_user_publications($db_shelter, $account['user_id']);
    $user_comments = get_user_comments($db_shelter, $account['user_id']);

    $user_rating = 0;
    foreach ($user_publications as $publ) {
      $user_rating += get_like_amount($db_shelter, $publ['publication_id']);
    }

    foreach ($user_publications as $publ) {
      $account_publications[$i] = array('publication_id' => $publ['publication_id'], 'author' => $account['user_name'], 'author_id' => $account['user_id'], 'author_image' => $account['image'], 'timestamp' => $publ['timestamp'], 'title' => $publ['title'], );
      $i++;
    }

    foreach ($user_comments as $comm) {
      $account_comments[$i] = array('commented_publication_author' => $comm['re_author'], 'commented_publication_author_id' => $comm['re_author_id'], 'commented_publication_title' => $comm['re_publ_title'], 'commented_publication_id' => $comm['re_publ_id'], 'author' => $account['user_name'],
        'author_id' => $account['user_id'], 'timestamp' => $comm['timestamp'], 'text' => $comm['text'], );
      $i++;
    }

    $account_info = array('user_id' => $account['user_id'], 'photo' => $account['image'], 'user_name' => $account['user_name'], 'user_status' => $account['status'], 'user_rating' => $user_rating, 'publications_amount' => count($user_publications), 'comments_amount' => count($user_comments),);

    echo $twig->render('account.html', array('account_info' => $account_info, 'account_publications' => $account_publications, 'account_comments' => $account_comments));
    return;
}

header('Location: http://'.$_SERVER['HTTP_HOST'].'/login.php');
