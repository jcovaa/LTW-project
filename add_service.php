<?php 

declare(strict_types = 1);
require_once 'templates/common.addservice.pages.php';
require_once __DIR__ . '/database/connection.db.php';
require_once __DIR__ . '/database/category.class.php';

$db = getDatabaseConnection();
$categories = Category::getCategories($db);

output_header("Add Service");
draw_service_form($categories);
output_footer();

?>