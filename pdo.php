<?php

require_once 'str_processer.php';

$db_shelter = new PDO('mysql:host=localhost;dbname=shelter', 'root', 'MySqlPassword09052020');

function get_user_account($db, $hash_value) {
  try {
    $stmt = $db->prepare("SELECT * FROM `user_account` WHERE `user_hash` = ?");
    $stmt->execute(array($hash_value));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $data = array('user_id' =>$row['user_id'], 'user_name' => $row['user_name'], 'user_hash' =>$row['user_hash'], 'email' => $row['email'], 'image' =>$row['image'],'status' =>$row['status']);
    return $data;
  }
  catch (PDOException $e) {
	  print "Error!: " . $e->getMessage();
	   die();
  }
}

function get_user_account_by_id($db, $acc_id) {
  try {
    $stmt = $db->prepare("SELECT * FROM `user_account` WHERE `user_id` = ?");
    $stmt->execute(array($acc_id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $data = array('user_id' =>$row['user_id'], 'user_name' => $row['user_name'], 'user_hash' =>$row['user_hash'], 'email' => $row['email'], 'image' =>$row['image'],'status' =>$row['status']);
    return $data;
  }
  catch (PDOException $e) {
	  print "Error!: " . $e->getMessage();
	   die();
  }
}

function get_user_publications($db, $user_id) {
  try {
    $stmt = $db->prepare("SELECT * FROM `full_publication` WHERE `author_id` = ?");
    $stmt->execute(array($user_id));
    $i = 0;
    while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
      $data[$i] = array('publication_id' =>$row['publication_id'], 'timestamp' => $row['timestamp'], 'title' =>$row['title']);
      $i++;
    }
    return $data;
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
     die();
  }
}

function get_user_comments($db, $user_id) {
  try {
    $stmt = $db->prepare("SELECT * FROM `full_comment` WHERE `author_id` = ?");
    $stmt->execute(array($user_id));
    $i = 0;
    while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {

      $stmt = $db->prepare("SELECT `author_id`, `title` FROM `full_publication` WHERE `publication_id` = ?");
      $stmt->execute(array($row['re_publ_id']));
      $items = $stmt->fetch(PDO::FETCH_ASSOC);

      $stmt = $db->prepare("SELECT `user_name` FROM `user_account` WHERE `user_id` = ?");
      $stmt->execute(array($items['author_id']));
      $author_value = $stmt->fetch(PDO::FETCH_COLUMN);

      $data[$i] = array('re_author_id' => $items['author_id'], 're_author' => $author_value, 're_publ_id' => $row['re_publ_id'], 're_publ_title' => $items['title'], 'timestamp' => $row['timestamp'], 'text' => $row['text']);
      $i++;
    }
    return $data;
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
     die();
  }
}

function get_publication_comments($db, $publ_id) {
  try {
    $stmt = $db->prepare("SELECT * FROM `full_comment` WHERE `re_publ_id` = ?");
    $stmt->execute(array($publ_id));
    $i = 0;
    while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {

      $st = $db->prepare("SELECT `user_name` FROM `user_account` WHERE `user_id` = ?");
      $st->execute(array($row['author_id']));
      $author_value = $st->fetch(PDO::FETCH_COLUMN);

      $data[$i] = array('author_id' => $row['author_id'], 'author' => $author_value, 're_publ_id' => $row['re_publ_id'], 'timestamp' => $row['timestamp'], 'text' => $row['text']);
      $i++;
    }
    return $data;
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
     die();
  }
}

function get_publications($db, $request) {
  try {
    $stmt = $db->prepare($request);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {

      $st = $db->prepare("SELECT `user_name`, `image` FROM `user_account` WHERE `user_id` = ?");
      $st->execute(array($row['author_id']));
      $items = $st->fetch(PDO::FETCH_ASSOC);

      $data[$i] = array('publication_id' => $row['publication_id'], 'author' => $items['user_name'], 'author_id' => $row['author_id'], 'author_photo_path' => $items['image'], 'timestamp' => $row['timestamp'], 'title' => $row['title'],
        'image_path' => $row['image'], 'text' => get_medium_text($row['text']));
      $i++;
    }
    return $data;
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
     die();
  }
}

function get_one_publication($db, $request, $params) {
  try {
    $stmt = $db->prepare($request);
    $stmt->execute($params);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $st = $db->prepare("SELECT `user_name`, `image` FROM `user_account` WHERE `user_id` = ?");
    $st->execute(array($row['author_id']));
    $items = $st->fetch(PDO::FETCH_ASSOC);

    $data = array('publication_id' => $row['publication_id'], 'author' => $items['user_name'], 'author_id' => $row['author_id'], 'author_photo_path' => $items['image'], 'timestamp' => $row['timestamp'], 'title' => $row['title'],
      'image_path' => $row['image'], 'text' => $row['text']);
    return $data;
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
     die();
  }
}


function is_user_registered($db, $hash_value) {
  try {
    $stmt = $db->prepare("SELECT count(*) AS num FROM `user_account` WHERE `user_hash` = ?");
    $stmt->execute(array($hash_value));
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($info['num'] != 0)
      return true;
    else
      return false;
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
  }
}

function is_user_unique($db, $username, $hash_value) {
  if (!is_user_registered($db, $hash_value)) {
    try {
      $stmt = $db->prepare("SELECT count(*) AS num FROM `user_account` WHERE `user_name` = ?");
      $stmt->execute(array($username));
      $info = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($info['num'] == 0)
        return true;
      else
        return false;
    }
    catch (PDOException $e) {
      print "Error!: " . $e->getMessage();
      die();
    }
  }
  else {
    return false;
  }
}

function register_user($db, $user_name, $email, $avatar, $hash_value) {
  try {
    $data = array('username' => $user_name, 'userhash' => $hash_value, 'email' => $email, 'image' => $avatar, 'status' => 'user');
    $stmt = $db->prepare("INSERT INTO `user_account` SET `user_name` = :username, `user_hash` = :userhash, `email` = :email, `image` = :image, `status` = :status");
    $stmt->execute($data);
    $insert_id = $db->lastInsertId();
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
  }
}

function add_comment($db, $data_arr) {
  try {
    $stmt = $db->prepare("INSERT INTO `full_comment` SET `author_id` = :author_id, `timestamp` = :timestamp, `re_publ_id` = :re_publ_id, `text` = :text");
    $stmt->execute($data_arr);
    $insert_id = $db->lastInsertId();
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
  }
}

function add_publication($db, $data_arr) {
  try {
    $stmt = $db->prepare("INSERT INTO `full_publication` SET `author_id` = :author_id, `timestamp` = :timestamp, `title` = :title, `text` = :text, `image` = :image");
    $stmt->execute($data_arr);
    $insert_id = $db->lastInsertId();
    return $insert_id;
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
  }
}

function get_current_insert_id($db) {
  try {
    $stmt = $db->prepare("SELECT MAX(`publication_id`) AS max FROM `full_publication`");
    $stmt->execute();
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    return $info['max'] + 1;
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
  }
}

function correct_like($db, $user_id, $publ_id) {
  try {
    $stmt = $db->prepare("SELECT count(*) AS num FROM `publication_likes` WHERE `user_id` = ? AND `publ_id` = ?");
    $stmt->execute(array($user_id, $publ_id));
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($info['num'] == 0) {
      $st = $db->prepare("INSERT INTO `publication_likes` SET `user_id` = :user_id, `publ_id` = :publ_id");
      $st->execute(array('user_id' => $user_id, 'publ_id' => $publ_id));
    }
    else {
      $st = $db->prepare("DELETE FROM `publication_likes` WHERE `user_id` = :user_id AND `publ_id` = :publ_id");
      $st->execute(array('user_id' => $user_id, 'publ_id' => $publ_id));
    }
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
  }
}

function is_publ_liked_by_user($db, $hash_value, $publ_id) {
  try {
    if ($hash_value == null)
      return false;
    $account = get_user_account($db, $hash_value);
    $user_id = $account['user_id'];
    $stmt = $db->prepare("SELECT count(*) AS num FROM `publication_likes` WHERE `user_id` = ? AND `publ_id` = ?");
    $stmt->execute(array($user_id, $publ_id));
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($info['num'] == 0) {
      return false;
    }
    else {
      return true;
    }
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
  }
}

function get_like_amount($db, $publ_id) {
  try {
    $stmt = $db->prepare("SELECT count(*) AS num FROM `publication_likes` WHERE `publ_id` = ?");
    $stmt->execute(array($publ_id));
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    return $info['num'];
  }
  catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
  }
}
