<?php
#declare(strict_types=1);

require_once __DIR__ . '/../database/session.php';
require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/admin.class.php';

$session = Session::getInstance();
$db = getDatabaseConnection();

if (!$session->isLoggedIn() || !Admin::isAdmin($db, $session->getUserId())) {
    http_response_code(403);
    die('Access denied.');
}

if (!isset($_POST['category_name']) || empty(trim($_POST['category_name']))) {
    http_response_code(400);
    die('Category name is required.');
}

$categoryName = trim($_POST['category_name']);

try {
    $stmt = $db->prepare('INSERT INTO Category (Name) VALUES (?)');
    $stmt->execute([$categoryName]);
    header('Location: ../admin_dashboard.php');
    exit();
} catch (PDOException $e) {
    http_response_code(500);
    die('Failed to create category.');
}

?>