<?php 

declare(strict_types = 1);
require_once __DIR__ . '/templates/common.login.pages.php';
require_once __DIR__ . '/templates/common.main.pages.php';
require_once __DIR__ . '/database/session.php';


output_header_("Login");
draw_messages();
draw_login_form();
output_footer();

?>