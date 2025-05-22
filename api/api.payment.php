<?php

declare(strict_types=1);

header('Content-Type: application/json');

require_once __DIR__ . '/../database/session.php';
require_once __DIR__ . '/../database/connection.db.php';

/* REST API METHOD */

$db = getDatabaseConnection();
$session = Session::getInstance();
$data = json_decode(file_get_contents('php://input'), true);




if (!$session->validateCSRFToken($data['csrf'] ?? '')) {
   http_response_code(403);
   echo json_encode(['error' => 'Invalid CSRF token']);
   exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   http_response_code(405);
   echo json_encode(['error' => 'Method not allowed']);
   exit();
}

$type = $data['type'] ?? 'order';
$serviceId = intval($data['service_id'] ?? 0);
$clientId = $session->getUserId();
$name = trim($data['name'] ?? '');
$address = trim($data['address'] ?? '');
$cc_number = $data['cc_number'] ?? '';
$expiry = $data['expiry'] ?? '';
$cvv = $data['cvv'] ?? '';

$errors = [];

if (!preg_match('/[a-zA-Z]/', $name)) {
   $errors[] = "Invalid name.";
}
if (empty($address)) {
   $errors[] = "Address is required.";
}
if (!preg_match('/^\d{16}$/', $cc_number)) {
   $errors[] = "Invalid credit card number.";
}
if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry)) {
   $errors[] = "Invalid expiry date.";
}
if (!preg_match('/^\d{3,4}$/', $cvv)) {
   $errors[] = "Invalid CVV.";
}
if (!$clientId) {
   $errors[] = "User not logged in.";
}

if ($errors) {
   http_response_code(400);
   echo json_encode(['errors' => implode(' ', $errors)]);
   exit();
}


if ($type === 'order') {
   $stmt = $db->prepare('
      INSERT INTO Order_ (ClientId, ServiceId, Status)
      VALUES (?, ?, ?)
   ');

   $stmt->execute([$clientId, $serviceId, 'Pending']);

   echo json_encode(['success' => true]);
   exit();

} elseif ($type === 'promotion') {
   require_once __DIR__ . '/../database/service.class.php';

   $service = Service::getService($db, $serviceId);
   if (!$service) {
      http_response_code(404);
      echo json_encode(['error' => 'Service not found']);
      exit();
   }

   $service->promoteService($db);

   $session->addMessage('success', "Service promoted successfully.");
   echo json_encode(['success' => true]);
   exit();
} else {
   http_response_code(400);
   echo json_encode(['error' => 'Invalid transaction type']);
   exit();
}
