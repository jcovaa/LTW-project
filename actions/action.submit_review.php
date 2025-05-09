<?php
declare(strict_types=1);

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/review.class.php';
require_once __DIR__ . '/../database/session.php';

$session = Session::getInstance();

function redirectWithError(string $message, string $location): void {
   $_SESSION['error'] = $message;
   header('Location: ' . $location);
   exit;
}

$referer = $_SERVER['HTTP_REFERER'] ?? '../index.php';

if (!$session->isLoggedIn()) {
   redirectWithError('You must be logged in to submit a review.', $referer);
}

if (!isset($_POST['service_id'], $_POST['rating'], $_POST['comment'])) {
   redirectWithError('All fields are required.', $referer);
}

$serviceId = (int)$_POST['service_id'];
$rating = (int)$_POST['rating'];
$comment = $_POST['comment'];

if ($rating < 1 || $rating > 5) {
   redirectWithError('Rating must be between 1 and 5.', $referer);
}

if (empty(trim($comment))) {
   redirectWithError('Comment cannot be empty.', $referer);
}

$comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');

$db = getDatabaseConnection();
$clientId = $session->getUserId();

try {
   $success = Review::addReview($db, $serviceId, $clientId, $rating, $comment);
    
   if ($success) {
      $_SESSION['success'] = 'Your review has been submitted successfully!';
   } else {
      $_SESSION['error'] = 'Failed to submit review.';
   }
} catch (Exception $e) {
   $_SESSION['error'] = 'Error: ' . $e->getMessage();
}

header('Location: ../service.php?id=' . $serviceId);
exit;
?>