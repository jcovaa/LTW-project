<?php 

declare(strict_types=1);
require_once 'templates/common.main.pages.php';
require_once 'templates/service.tpl.php';

output_header("Service");
draw_service_categories();
draw_service_page();
output_footer();
