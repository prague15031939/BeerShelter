<?php

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'cache'       => 'compilation_cache',
    'auto_reload' => true
));

$twig -> addGlobal('account_photo', 'images/avatar1.png');

$publication = 	array('author' => 'Jason', 'author_image' => 'images/avatar1.png', 'timestamp' => '7:14', 'title' => 'Paulaner Hefe-Weisbeer', 'text' => 'Paulaner Hefe-Weissbier Naturtrub. Под конец года нужно было выбрать что-то, что гарантированно не будет плохо, ведь как проведешь/встретишь, так и будет(по крайней мере так говорят). Это пиво является самым популярным из всей линейки Paulaner, а также живой классикой как для немцев, так и для всего мира.
	По цвету пиво оранжеватое, с туманностью Альбиона. По аромату при вдохе чувствуются какие то легкие восточные специи и пшеничность, пресловутого аромата банана я не нащупал. 
	Дальше по вкусу: пиво легкое, очень сбалансированное, но в тоже время насыщенное. Горечь едва заметна и лишь играет на фоне и мягко скрашивает послевкусие. 
	Хорошее пиво, вкусное, пьётся легко и приятно, любителям пшеничного обязано понравится, но ничего особенного в нем не нашлось. 8/10', 'image' => 'images/paulaner.png', 
	'like_amount' => 278);

$comments = array(
	array('author' => 'prague15031939', 'timestamp' => '13:13', 'text' => '10/10. Нестареющая мюнхенская классика. Чистейший вкус, отдающий благородством. Лучшее пшеничное пиво на рынке.', ),
	array('author' => 'Andrew', 'timestamp' => '22:56', 'text' => 'Paulaner мне нравится за исключением одного яркого момента. 
		Почему никто не упоминает про то, что к середине бутылки он начинает ужасно кислить.
		Без закуски неочень приятно заходит.', ),
);

echo $twig->render('publication.html', array('publication' => $publication, 'comments' => $comments));
