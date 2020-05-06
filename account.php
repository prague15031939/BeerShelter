<?php

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'cache'       => 'compilation_cache',
    'auto_reload' => true
));

$twig -> addGlobal('account_photo', 'images/avatar1.png');

$account_info = array(
	'photo' => 'images/avatar1.png', 'id' => 'prague15031939', 'user_status' => 'admin', 'user_rating' => 60, 'publications_amount' => 3, 'comments_amount' => 2,
);

$account_publications = array(
	array('author' => 'Jason', 'author_image' => 'images/avatar1.png', 'timestamp' => '7:14', 'title' => 'Paulaner Hefe-Weisbeer', ),
	array('author' => 'Robbie', 'author_image' => 'images/avatar2.png', 'timestamp' => '22:10', 'title' => 'Kult Крыніца', ),
	array('author' => 'Kevin', 'author_image' => 'images/avatar3.png', 'timestamp' => '16:19', 'title' => 'Guiness Draught Stout', ),
);

$account_comments = array(
	array('commented_publication_author' => 'Broky', 'commented_publication_title' => 'Tuborg', 'author' => 'prague15031939', 'timestamp' => '13:13', 'text' => 'Отвратительное водянистое зелёное пойло. Очень сильное ощущение разбавленного спирта. Голова трещит уже после 1.5 литров. ', ),
	array('commented_publication_author' => 'Kitik', 'commented_publication_title' => 'Gambrinus', 'author' => 'prague15031939', 'timestamp' => '18:29', 'text' => 'Полностью поддерживаю. Отличное стабильное вкусное пиво. Прекрасный пивной аромат. Лучшее в среднем ценовом сегменте.', ),
);

echo $twig->render('account.html', array('account_info' => $account_info, 'account_publications' => $account_publications, 'account_comments' => $account_comments));
