<?php
#declare(strict_types=1);

require_once(__DIR__ . '/../database/session.php');

$session = Session::getInstance();

if (!$session->validateCSRFToken($_POST['csrf'] ?? '')) {
    $session->addMessage('error', 'Invalid CSRF token. Please try again.');
    header('Location: /');
    exit();
}

$session->logout();

header('Location: /');
?>