<?php
declare(strict_types = 1);

require_once __DIR__ . '/templates/common.main.pages.php';
require_once __DIR__ . '/templates/service.tpl.php';

require_once __DIR__ . '/database/connection.db.php';
require_once __DIR__ . '/database/service.class.php';
require_once __DIR__ . '/database/session.php';
require_once __DIR__ . '/database/category.class.php';

$db = getDatabaseConnection();

$services = Service::getAllServices($db);   // can later be getNServices to limit number of services
$featuredServices = Service::getPromotedServices($db);
$session =  Session::getInstance();
$categories = Category::getCategories($db);

output_header("Home", $session);
draw_filter_section($categories);
draw_featured_services($featuredServices);
draw_services($services);
output_footer();

?>