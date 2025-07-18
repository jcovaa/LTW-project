<?php
declare(strict_types=1);

require_once __DIR__ . '/database/connection.db.php';
require_once __DIR__ . '/database/session.php';
require_once __DIR__ . '/database/user.class.php';
require_once __DIR__ . '/database/category.class.php';
require_once __DIR__ . '/templates/common.main.pages.php';

require_once __DIR__ . '/templates/admin_dashboard.tpl.php';

$session = Session::getInstance();
$db = getDatabaseConnection();

if (!$session->isLoggedIn() || !$session->isAdmin()) {
    header('Location: index.php');
    exit;
}

$users = User::getUsers($db, 100);
$categories = Category::getCategories($db);

output_header_admin("Admin Dashboard", $session);
draw_dashboard_sidebar();
draw_admin_panel($users, $categories, $session, $db);

