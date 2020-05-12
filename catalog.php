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

$all_publications = get_publications($db_shelter, "SELECT * FROM `full_publication`");

echo $twig->render('catalog.html', array('all_publications' => $all_publications));
