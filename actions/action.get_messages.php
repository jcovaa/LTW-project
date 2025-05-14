<?php 
declare(strict_types=1);

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/session.php';
require_once __DIR__ . '/../database/message.class.php';

$session = Session::getInstance();

header('Content-Type: application/json');

if (!$session->isLoggedIn()) {
   echo json_encode(['success' => false, 'error' => 'You must be logged in to view messages']);
   exit;
}

if (!isset($_GET['receiver_id'])) {
   echo json_encode(['success' => false, 'error' => 'Missing receiver ID']);
   exit;
}

$currentUserId = $session->getUserId();
$receiverId = (int)$_GET['receiver_id'];

try {
   $db = getDatabaseConnection();
   $messages = Message::getConversation($db, $currentUserId, $receiverId);

   $messageData = [];
   foreach ($messages as $message) {
      $messageData[] = [
         'id' => $message->id,
         'senderId' => $message->senderId,
         'receiverId' => $message->receiverId,
         'content' => $message->content,
         'sentAt' => $message->sentAt
      ];
   }

   echo json_encode(['success' => true, 'currentUserId' => $currentUserId, 'messages' => $messageData]);
} catch (PDOException $e) {
   echo json_encode(['success' => false, 'error' => 'Database error' . $e->getMessage()]);
}

?>