<?php
#declare(strict_types=1);

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/admin.class.php';
require_once __DIR__ . '/../database/session.php';

$session = Session::getInstance();
$db = getDatabaseConnection();

// check if you're logged in AND an admin
if (!$session->isLoggedIn() || !Admin::isAdmin($db, $session->getUserId())) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// check if userID to elevate to admin was sent

if (!isset($_POST['user_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing userId']);
    exit;
}

$targetUserId = intval($_POST['user_id']);
//$db = getDatabaseConnection();

// check if targetted user is an admin already
if (Admin::isAdmin($db, $targetUserId)) {
    echo json_encode(['message' => 'User is already an admin']);
    exit;
}

// elevate user to admin
try {
    $stmt = $db->prepare('INSERT INTO Admin (UserId) VALUES (?)');
    $stmt->execute([$targetUserId]);
    echo json_encode(['message' => 'User elevated to admin']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to elevate user']);
}

?>