<?php 

declare(strict_types = 1);
require_once 'templates/addservice.tpl.php';
require_once 'templates/common.main.pages.php';

require_once __DIR__ . '/database/service.class.php';
require_once __DIR__ . '/database/connection.db.php';
require_once __DIR__ . '/database/category.class.php';
require_once __DIR__ . '/database/session.php';

$db = getDatabaseConnection();

$session =  Session::getInstance();

$categories = Category::getCategories($db);

output_header_("Add Service", $session);
draw_messages();
draw_service_form($categories);
output_footer();

?>