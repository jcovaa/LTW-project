<?php 
declare(strict_types=1);

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/session.php';

$session = Session::getInstance();

header('Content-Type: application/json');



if (!$session->isLoggedIn()) {
   echo json_encode(['success' => false, 'error' => 'You must be logged in to send messages']);
   exit;
}

if (!isset($_POST['receiver_id']) || !isset($_POST['message'])) {
   echo json_encode(['success' => false, 'error' => 'Missing parameters']);
   exit;
}

$senderId = $session->getUserId();
$receiverId = (int)$_POST['receiver_id'];
$message = trim($_POST['message']);

if (empty($message)) {
   echo json_encode(['success' => false, 'error' => 'Message cannot be empty']);
   exit;
}

try {
   $db = getDatabaseConnection();

   $stmt = $db->prepare('
      INSERT INTO Message (SenderId, ReceiverId, Content, SentAt)
      VALUES (?, ?, ?, CURRENT_TIMESTAMP)
   ');

   $stmt->execute([$senderId, $receiverId, $message]);

   echo json_encode(['success' => true]);
} catch (PDOException $e) {
   echo json_encode(['success' => false, 'error' => 'Database error']);
}

?>