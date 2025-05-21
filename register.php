<?php 

declare(strict_types = 1);
require_once __DIR__ . '/templates/common.login.pages.php';
require_once __DIR__ . '/database/session.php';
require_once __DIR__ . '/templates/common.main.pages.php';

$session = Session::getInstance();

output_header_("Register", $session);
draw_messages();
draw_register_form();
output_footer();

?>