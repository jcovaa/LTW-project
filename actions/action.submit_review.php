<?php 
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/review.class.php';
require_once __DIR__ . '/../database/session.php';

if (!Session::getInstance()->isLoggedIn()) {
   $_SESSION['error'] = 'You must be logged in to submit a review.';
   header('Location: ' . $_SERVER['HTTP_REFERER']);
   exit();
}

if (!isset($_POST['service_id'], $_POST['rating'], $_POST['comment'])) {
   $_SESSION['error'] = 'Missing required fields.';
   header('Location: ' . $_SERVER['HTTP_REFERER']);
   exit();
}

$db = getDatabaseConnection();
$serviceId = intval($_POST['service_id']);
$rating = intval($_POST['rating']);
$comment = $_POST['comment'];
$userId = Session::getInstance()->getUserId();

if ($rating < 1 || $rating > 5) {
   $_SESSION['error'] = 'Rating must be between 1 and 5';
   header('Location: ' . $_SERVER['HTTP_REFERER']);
   exit();
}

try {
   $stmt = $db->prepare('
      INSERT INTO Review (ServiceId, ClientId, Rating, Comment)
      VALUES (?, ?, ?, ?)
   ');

   $stmt->execute([$serviceId, $userId, $rating, $comment]);
   $_SESSION['success'] = 'Your review has been submitted successfully.';
} catch (PDOException $e) {
   $_SESSION['error'] = 'An error occured while submitting your review.';
}

?>