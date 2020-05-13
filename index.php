<?php

require_once 'twig_init.php';
require_once 'pdo.php';

function get_top_publications($db, $publications) {
  foreach ($publications as $publ) {
    $mid_res[$publ['publication_id']] = get_like_amount($db, $publ['publication_id']);
  }
  arsort($mid_res);
  $i = 0;
  $res = array();
  foreach ($mid_res as $k => $v) {
    if ($i == 3)
      break;
    foreach ($publications as $publ) {
      if ($publ['publication_id'] == $k)
        $res[$i] = $publ;
    }
    $i++;
  }
  return $res;
}

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

echo $twig->render('main_page.html', array('top_publications' => get_top_publications($db_shelter, $all_publications)));
