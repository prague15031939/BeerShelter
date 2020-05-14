<?php

require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/Exception.php';

require_once 'top_publications.php';

function send_message($user_mail, $msg){
	$mail = new PHPMailer\PHPMailer\PHPMailer();
	try {
		$mail->isSMTP();
		$mail->CharSet = "UTF-8";
		$mail->SMTPAuth   = true;
		$mail->Host       = 'ssl://smtp.mail.ru';
		$mail->Username   = 'prague15031939@mail.ru';
		$mail->Password   = 'for_beer_shelter_mail999';
		$mail->SMTPSecure = 'ssl';
		$mail->Port       = 465;
		$mail->setFrom('prague15031939@mail.ru', 'prague15031939');
		$mail->addAddress($user_mail);
		$mail->isHTML(true);
		$mail->Subject = "BeerShelter Top Reviews";
		$mail->Body    = $msg;
		if ($mail->send()) {
			return 1;
		}
	}
	catch (Exception $e) {
		return 0;
	}
}

function send_mail($db, $email, $user_name) {
  $all_publications = get_publications($db, "SELECT * FROM `full_publication`");
  $top_publications = get_top_publications($db, $all_publications);

  $msg = '<b>Dear ' . $user_name . '!</b><br>Welcome back to BeerShelter. Feel free to use all opportunities to express yourself on our platform.<br>You are proposed to take a look at the most popular beer reviews today!<br><br>';
  foreach ($top_publications as $publ) {
    $account = get_user_account_by_id($db, $publ['author_id']);
    $msg .= '&#9675; ' . $account['user_name'] . ' - ' . $publ['title'] . '<br>' . '&nbsp;&nbsp;&nbsp;' . $publ['timestamp'] . '<br><br>';
  }
  $msg .= '<b>Sincerly yours, prague15031939</b>';
  send_message($email, $msg);
}
