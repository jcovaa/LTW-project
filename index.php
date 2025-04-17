<?php
declare(strict_types = 1);

require_once __DIR__ . '/templates/common.main.pages.php';
require_once __DIR__ . '/templates/service.tpl.php';

output_header("Home");
draw_filter_section();
draw_featured_services();
draw_services();
output_footer();

?>