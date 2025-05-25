<?php
declare(strict_types = 1);

require_once __DIR__ . '/templates/common.profile.pages.php';
require_once __DIR__ . '/templates/common.main.pages.php';
require_once __DIR__ . '/database/session.php';
require_once __DIR__ . '/database/connection.db.php';

$db = getDatabaseConnection();

$session =  Session::getInstance();
$user = User::getUser($db, $session->getUserId());

output_header("Profile", $session);
draw_profile_sidebar();
draw_profile($user);
output_footer();

?>