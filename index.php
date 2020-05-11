<?php

require_once 'twig_init.php';
require_once 'pdo.php';

session_start();

if ($_SESSION['hash'] != null) {
    $account = get_user_account($db_shelter, $_SESSION['hash']);
    $twig -> addGlobal('account_photo', $account['image']);
    $twig -> addGlobal('signed_in', true);
}
else {
    $twig -> addGlobal('signed_in', false);
}

$top_publications = get_publications($db_shelter, "SELECT * FROM `full_publication` WHERE `author_id`>0 ORDER BY `like_amount` DESC LIMIT 3");

echo $twig->render('main_page.html', array('top_publications' => $top_publications));
