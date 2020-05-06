<?php

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'cache'       => 'compilation_cache',
    'auto_reload' => true
));

$twig -> addGlobal('account_photo', 'images/avatar1.png');

$top_publications = array(
	array('author' => 'Jason', 'author_photo_path' => 'images/avatar1.png', 'timestamp' => '22:13', 'title' => 'Paulaner Hefe-Weisbeer', 'image_path' => 'images/paulaner.png', 'text' => 'По цвету пиво оранжеватое, с туманностью Альбиона. По аромату при вдохе чувствуются какие то легкие восточные специи и пшеничность, пресловутого аромата банана я не нащупал. Дальше по вкусу: пиво легкое, очень сбалансированное, но в тоже время насыщенное. Горечь едва заметна и лишь играет на фоне и мягко скрашивает послевкусие. Хорошее пиво, вкусное, пьётся легко и приятно, любителям пшеничного обязано понравится, но ничего особенного в нем не нашлось.'),
	array('author' => 'Robbie', 'author_photo_path' => 'images/avatar2.png', 'timestamp' => '14:15', 'title' => 'Kult Крыніца', 'image_path' => 'images/kult.png', 'text' => 'Крыница Kult Weissbier. По запаху очень приятное, по началу даже слегка напоминает Paulaner. Наверное тем, что это пиво пшеничное, но не так уж ярко выраженное. По вкусу схожести чуть меньше, но вкус все равно приятный, с небольшой горчинкой. Вот оно вроде не водянистое, но плотности слегка не хватает что-ли. Послевкусие мягкое и протяжное,вяжущее. Через некоторое время во вкусе появляются сладковатые и кисловатые оттенки.'),
	array('author' => 'Kevin', 'author_photo_path' => 'images/avatar3.png', 'timestamp' => '7:45', 'title' => 'Guiness Draught Stout', 'image_path' => 'images/guiness.png', 'text' => 'Процедура наливания пива Гиннесс представляет из себя целый ритуал. Идеальная пинта должна наливаться за два подхода. Пиво должно наливаться в бокал, наклонённый на 45° ровно (не дай бог немного больше, и злобный ценитель, сидящий рядом с транспортиром, разобьёт Вам лицо). За первый раз наливается три четверти бокала. Потом необходимо подождать, пока поднимется вся пена. Затем под большим напором доливают оставшуюся четверть пива через специальный сепаратор — это необходимо для создания обильной пены. Вся процедура должна занимать ровно 119,53 секунды. В общем, я не знаю, зачем им такие сложности. Похоже, избыток свободного времени.'),
);

echo $twig->render('main_page.html', array('top_publications' => $top_publications));