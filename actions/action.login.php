<?php
 declare(strict_types=1);

 session_start();

 require_once('../database/connection.db.php');
 require_once('../database/user.class.php');
 require_once('../database/session.php');


 $db = getDatabaseConnection();

 $email = $_POST['email'];
 $password = $_POST['password'];


 $user = User::getUserWithPassword($db, $email, $password);

 if ($user) Session::getInstance()->login($user);

 header('Location: /');
?>
