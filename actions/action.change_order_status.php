<?php


declare(strict_types=1);
require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/order.class.php';
require_once __DIR__ . '/../database/session.php';

$session = Session::getInstance();

if (!$session->validateCSRFToken($_POST['csrf'] ?? '')) {
    $session->addMessage('error', 'Invalid CSRF token. Please try again.');
    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/');
    exit();
}

$db = getDatabaseConnection();

$orderId = intval($_POST['order_id']);
$newStatus = $_POST['new_status'];
$userId = $session->getUserId();
$order = Order::getOrder($db, $orderId);


if (!$order) {
    die("Order not found");
}

$currentStatus = $order->status;


$validTransitions = [
    'pending' => ['in_progress'],
    'in_progress' => ['complete']
];

if (!isset($validTransitions[$currentStatus]) || !in_array($newStatus, $validTransitions[$currentStatus])) {
    die("Invalid status transition");
}


$order->updateStatus($db, $newStatus);

header("Location: {$_SERVER['HTTP_REFERER']}"); // redirect or return success
