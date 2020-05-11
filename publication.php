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

$publication = get_one_publication($db_shelter, "SELECT * FROM `full_publication` WHERE `publication_id`=?", array($_GET['publ_id']));

$comments = get_publication_comments($db_shelter, $_GET['publ_id']);

echo $twig->render('publication.html', array('publication' => $publication, 'comments' => $comments));
