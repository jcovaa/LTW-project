<?php 

declare(strict_types=1);
require_once __DIR__ . '/templates/common.main.pages.php';
require_once __DIR__ . '/templates/service.tpl.php';

require_once __DIR__ . '/database/connection.db.php';
require_once __DIR__ . '/database/service.class.php';
require_once __DIR__ . '/database/category.class.php';
require_once __DIR__ . '/database/review.class.php';

$db = getDatabaseConnection();

$service = Service::getService($db, intval($_GET['id']));

$categories = Category::getServiceCategories($db, $service->id);

$ratingsData = Review::getRatingsData($db, $service->id);

output_header("Service");
draw_service_categories($categories);
draw_service_page($service, $ratingsData);
output_footer();