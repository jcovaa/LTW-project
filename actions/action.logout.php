<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/session.php');

Session::getInstance()->logout();

header('Location: /');
?>