<?php
declare(strict_types=1);

require_once('../database/connection.db.php');
require_once('../database/user.class.php');
require_once('../database/session.php');

$session = Session::getInstance();
$db = getDatabaseConnection();

$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

if (empty($name) || empty($username) || empty($email) || empty($password)) {
    $session->addMessage('error', 'All fields are required.');
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

if (User::exists($db, $email, $username)) {
    $session->addMessage('error', 'Email or username already taken.');
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

try {
    User::create($db, $name, $username, $email, $password);
    $session->addMessage('success', 'Account created successfully. You can now log in.');
    header('Location: /');
} catch (Exception $e) {
    $session->addMessage('error', 'Something went wrong while creating your account.');
    header("Location: " . $_SERVER['HTTP_REFERER']);
}


header('Location: /');  // after a user register, this redirects him to the main page
?>