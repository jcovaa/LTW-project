<?php
declare(strict_types=1);

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/admin.class.php';
require_once __DIR__ . '/../database/session.php';

$session = Session::getInstance();
$db = getDatabaseConnection();

if (!$session->validateCSRFToken($_POST['csrf'] ?? '')) {
    $session->addMessage('error', 'Invalid CSRF token. Please try again.');
    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/');
    exit();
}

// check if you're logged in AND an admin
if (!$session->isLoggedIn() || !Admin::isAdmin($db, $session->getUserId())) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// check if userID to remove was sent
if (!isset($_POST['user_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing userId']);
    exit;
}

$targetUserId = intval($_POST['user_id']);

// check if targetted user is an admin already
if (!Admin::isAdmin($db, $targetUserId)) {
    echo json_encode(['message' => 'User is not an admin']);
    exit;
}

// remove from admin table
try {
    $stmt = $db->prepare('DELETE FROM Admin WHERE UserId = ?');
    $stmt->execute([$targetUserId]);
    echo json_encode(['message' => 'Admin demoted successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to demote admin']);
}

?>
