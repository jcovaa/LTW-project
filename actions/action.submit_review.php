<?php
declare(strict_types=1);

require_once('../database/connection.db.php');
require_once('../database/review.class.php');
require_once('../database/session.php');

$session = Session::getInstance();

if (!$session->isLoggedIn()) {
    $_SESSION['error'] = 'You must be logged in to submit a review.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

if (!isset($_POST['service_id'], $_POST['rating'], $_POST['comment'])) {
    $_SESSION['error'] = 'All fields are required.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$serviceId = (int)$_POST['service_id'];
$rating = (int)$_POST['rating'];
$comment = $_POST['comment'];

if ($rating < 1 || $rating > 5) {
    $_SESSION['error'] = 'Rating must be between 1 and 5 stars.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

if (empty(trim($comment))) {
    $_SESSION['error'] = 'Comment cannot be empty.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

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