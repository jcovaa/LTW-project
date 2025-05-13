<?php

declare(strict_types=1);

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/service.class.php';
require_once __DIR__ . '/../database/session.php';

$session = Session::getInstance();
$db = getDatabaseConnection();
$id = (int) $_POST['id'];

$service = Service::getService($db, $id);


if (!$service) {
    $_SESSION['error'] = "Service not found.";
    header('Location: ../freelancer_dashboard.php');
    exit();
}

// verifies AGAIN if the user logged in is this service's freelancer
if ($session->getUserId() !== $service->freelancerId) {
    $_SESSION['error'] = "You don't have permission to update this service.";
    header('Location: ../freelancer_dashboard.php');
    exit();
}

$service->name = $_POST['name'];
$service->description = $_POST['description'];
$service->price = doubleval($_POST['price']);
$service->deliveryTime = intval($_POST['deliveryTime']);

// Delete the service
if ($service->updateService($db)) {
    $_SESSION['success'] = "Service updated successfully.";
} else {
    $_SESSION['error'] = "Failed to update the service.";
}

header('Location: ../freelancer_dashboard.php');
exit();
