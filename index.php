<?php

require_once 'twig_init.php';
require_once 'pdo.php';

session_start();

if ($_SESSION['hash'] != null) {
    $twig -> addGlobal('user_status', $_SESSION['user_status']);
    $twig -> addGlobal('account_photo', $_SESSION['account_photo']);
    $twig -> addGlobal('signed_in', true);
}
else {
    $twig -> addGlobal('signed_in', false);
}

$top_publications = get_publications($db_shelter, "SELECT * FROM `full_publication` WHERE `author_id`>0 ORDER BY `like_amount` DESC LIMIT 3");

echo $twig->render('main_page.html', array('top_publications' => $top_publications));
