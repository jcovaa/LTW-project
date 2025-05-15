<?php
declare(strict_types = 1);

require_once __DIR__ . '/templates/common.profile.pages.php';

require_once __DIR__ . '/database/connection.db.php';
require_once __DIR__ . '/database/session.php';
require_once __DIR__ . '/database/category.class.php';

$db = getDatabaseConnection();

$session = Session::getInstance();

output_header("Your Orders", $session);
draw_profile_sidebar();
draw_profile_links();
draw_profile_edit($session);
output_footer();

?>