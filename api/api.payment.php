<?php
declare(strict_types = 1);

header('Content-Type: application/json');

require_once __DIR__ . '/../database/session.php';
require_once __DIR__ . '/../database/connection.db.php';

/* REST API METHOD */ 

$db = getDatabaseConnection();
$session = Session::getInstance();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   http_response_code(405);
   echo json_encode(['error' => 'Method not allowed']);
   exit();
}

$data = json_decode(file_get_contents('php://input'), true);

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

$stmt = $db->prepare('
   INSERT INTO Order_ (ClientId, ServiceId, Status)
   VALUES (?, ?, ?)
');

$stmt->execute([$clientId, $serviceId, 'pending']);

echo json_encode(['success' => true]);
exit();

?>