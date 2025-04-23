<?php 

declare(strict_types = 1);
require_once __DIR__ . '/templates/common.login.pages.php';

output_header("Register");
draw_register_form();
output_footer();

?>