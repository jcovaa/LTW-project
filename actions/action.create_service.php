<?php

declare(strict_types=1);

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/service.class.php';
require_once __DIR__ . '/../database/session.php';

$session = Session::getInstance();

function redirectWithError(string $message, string $location): void
{
    $_SESSION['error'] = $message;
    header('Location: ' . $location);
    exit;
}

$referer = $_SERVER['HTTP_REFERER'] ?? '../index.php';


if (!isset($_POST['name'], $_POST['description'], $_POST['category'], $_POST['delivery'], $_POST['price'])) {
    redirectWithError('All fields are required.', $referer);
}

$clientId = $session->getUserId();
$name = $_POST['name'];
$price = $_POST['price'];
$deliveryTime = $_POST['delivery'];
$description = $_POST['description'];


$imageUrl = null;
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

    $imageUrl = '../images/' . $newImageName;
} else {
    redirectWithError('Image upload failed or no image uploaded.', $referer);
}



$db = getDatabaseConnection();
$clientId = $session->getUserId();

try {
    $success = Service::addService($db, $name, $clientId, $price, $deliveryTime, $description, $imageUrl);

    if ($success) {
        $_SESSION['success'] = 'Service created successfully!';

    } else {
        $_SESSION['error'] = 'Failed to create service.';
        
    }
} catch (Exception $e) {
    $_SESSION['error'] = 'Error: ' . $e->getMessage();
    
}


header('Location: ../index.php');
exit;

?>