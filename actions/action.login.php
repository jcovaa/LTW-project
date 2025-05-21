<?php

declare(strict_types=1);


require_once('../database/connection.db.php');
require_once('../database/user.class.php');
require_once('../database/session.php');

$session = Session::getInstance();

$db = getDatabaseConnection();

$email = $_POST['email'];
$password = $_POST['password'];


$user = User::getUserWithPassword($db, $email, $password);

if ($user) {
    $session->login($user);
    $session->addMessage('success', 'Login successful');
    header("Location: ../index.php"); 
}
else {
    $session->addMessage('error', 'Invalid email or password');
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

