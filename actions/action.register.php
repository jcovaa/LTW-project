<?php
declare(strict_types=1);

require_once('../database/connection.db.php');
require_once('../database/user.class.php');

$db = getDatabaseConnection();

$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

User::create($db, $name, $username, $email, $password);

header('Location: /');  // after a user register, this redirects him to the main page
?>