<?php

require_once 'twig_init.php';
require_once 'pdo.php';

session_start();

if ($_SESSION['hash'] != null || count($_GET) > 0) {
    if (count($_GET) > 0) {
      $account = get_user_account_by_id($db_shelter, $_GET['acc_id']);
    }
    else {
      $account = get_user_account($db_shelter, $_SESSION['hash']);
    }
    $user_publications = get_user_publications($db_shelter, $account['user_id']);
    $user_comments = get_user_comments($db_shelter, $account['user_id']);

    $twig -> addGlobal('account_photo', $account['image']);
    $twig -> addGlobal('signed_in', true);

    foreach ($user_publications as $publ) {
      $account_publications[$i] = array('publication_id' => $publ['publication_id'], 'author' => $account['user_name'], 'author_id' => $account['user_id'], 'author_image' => $account['image'], 'timestamp' => $publ['timestamp'], 'title' => $publ['title'], );
      $i++;
    }

    foreach ($user_comments as $comm) {
      $account_comments[$i] = array('commented_publication_author' => $comm['re_author'], 'commented_publication_author_id' => $comm['re_author_id'], 'commented_publication_title' => $comm['re_publ_title'], 'commented_publication_id' => $comm['re_publ_id'], 'author' => $account['user_name'],
        'author_id' => $account['user_id'], 'timestamp' => $comm['timestamp'], 'text' => $comm['text'], );
      $i++;
    }

    $account_info = array('user_id' => $account['user_id'], 'photo' => $account['image'], 'user_name' => $account['user_name'], 'user_status' => $account['status'], 'user_rating' => $account['rating'], 'publications_amount' => count($user_publications), 'comments_amount' => count($user_comments),);

    echo $twig->render('account.html', array('account_info' => $account_info, 'account_publications' => $account_publications, 'account_comments' => $account_comments));

}
else {
  header('Location: http://'.$_SERVER['HTTP_HOST'].'/login.php');
}
