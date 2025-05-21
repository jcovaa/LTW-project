<?php

declare(strict_types=1);

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/service.class.php';
require_once __DIR__ . '/../database/session.php';

$session = Session::getInstance();

if (!$session->validateCSRFToken($_POST['csrf'] ?? '')) {
    $session->addMessage('error', 'Invalid CSRF token. Please try again.');
    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/');
    exit();
}

$db = getDatabaseConnection();
$id = (int) $_POST['id'];

$service = Service::getService($db, $id);


if (!$service) {
    $session->addMessage('error', "Service not found.");
    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/');
    exit();
}

// verifies AGAIN if the user logged in is this service's freelancer
if ($session->getUserId() !== $service->freelancerId) {
    $session->addMessage('error', "You don't have permission to delete this service.");
    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/');
    exit();
}

// Delete the service
if ($service->deleteService($db)) {
    $session->addMessage('success', "Service deleted successfully.");
} else {
    $session->addMessage('error', "Failed to delete the service.");
}

header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/');
exit();

