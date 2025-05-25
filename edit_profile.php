<?php
declare(strict_types = 1);

require_once __DIR__ . '/templates/common.profile.pages.php';
require_once __DIR__ . '/templates/common.main.pages.php';

require_once __DIR__ . '/database/connection.db.php';
require_once __DIR__ . '/database/session.php';
require_once __DIR__ . '/database/user.class.php';

$db = getDatabaseConnection();

$session = Session::getInstance();
$user = User::getUser($db, $session->getUserId());

output_header_profile("Edit Profile", $session);
draw_profile_edit($user, $session);
output_footer();

?>