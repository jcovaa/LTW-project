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

function redirectWithError(string $message, string $location): void
{
    Session::getInstance()->addMessage('error', $message);
    header('Location: ' . $location);
    exit;
}


$referer = $_SERVER['HTTP_REFERER'] ?? '/';


if (!$service) {
    $session->addMessage('error', "Service not found.");
    header('Location: ' . $referer);
    exit();
}

// verifies AGAIN if the user logged in is this service's freelancer
if ($session->getUserId() !== $service->freelancerId) {
    $session->addMessage('error', "You don't have permission to update this service.");
    header('Location: ' . $referer);
    exit();
}

$service->name = $_POST['name'];
$service->description = $_POST['description'];
$service->price = doubleval($_POST['price']);
$service->deliveryTime = intval($_POST['deliveryTime']);


if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tempFileName = $_FILES['image']['tmp_name'];
    $imageName = basename($_FILES['image']['name']);
    $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    if (!in_array($imageExtension, $allowedExtensions)) {
        redirectWithError('Unsupported image format.', $referer);
    }

    $newImageName = uniqid('img_', true) . '.' . $imageExtension;
    $uploadDir = __DIR__ . '/../images/';
    $uploadPath = $uploadDir . $newImageName;

    if (!move_uploaded_file($tempFileName, $uploadPath)) {
        redirectWithError('Failed to upload image.', $referer);
    }

    $service->imageUrl = '../images/' . $newImageName;
}
// Else: don't change the imageUrl — keep the old one




// update the service
if ($service->updateService($db)) {
    $session->addMessage('success', "Service updated successfully.");
} else {
    $session->addMessage('error', "Failed to update the service.");
}

header('Location: ' . $referer);
exit();
