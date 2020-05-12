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

$publication = get_one_publication($db_shelter, "SELECT * FROM `full_publication` WHERE `publication_id`=?", array($_GET['publ_id']));

$comments = get_publication_comments($db_shelter, $_GET['publ_id']);

echo $twig->render('publication.html', array('publication' => $publication, 'comments' => $comments));
