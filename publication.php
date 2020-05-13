<?php

require_once 'twig_init.php';
require_once 'pdo.php';

session_start();

if (count($_GET) == 0) {
  header('Location: http://'.$_SERVER['HTTP_HOST'].'/index.php');
}

if ($_SESSION['hash'] != null) {
    $twig -> addGlobal('user_status', $_SESSION['user_status']);
    $twig -> addGlobal('account_photo', $_SESSION['account_photo']);
    $twig -> addGlobal('signed_in', true);
}
else {
    $twig -> addGlobal('signed_in', false);
}

$publication = get_one_publication($db_shelter, "SELECT * FROM `full_publication` WHERE `publication_id`=?", array($_GET['publ_id']));

$comments = get_publication_comments($db_shelter, $_GET['publ_id']);

if (is_publ_liked_by_user($db_shelter, $_SESSION['hash'], $_GET['publ_id'])) {
    $twig -> addGlobal('heart_image', 'images/heart_liked.png');
}
else {
    $twig -> addGlobal('heart_image', 'images/heart.png');
}

$publication['like_amount'] = get_like_amount($db_shelter, $_GET['publ_id']);

echo $twig->render('publication.html', array('publication' => $publication, 'comments' => $comments));
