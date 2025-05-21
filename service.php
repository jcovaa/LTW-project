<?php 

declare(strict_types=1);
require_once __DIR__ . '/templates/common.main.pages.php';
require_once __DIR__ . '/templates/service.tpl.php';

require_once __DIR__ . '/database/connection.db.php';
require_once __DIR__ . '/database/service.class.php';
require_once __DIR__ . '/database/category.class.php';
require_once __DIR__ . '/database/review.class.php';
require_once __DIR__ . '/database/session.php';

$db = getDatabaseConnection();


$session =  Session::getInstance();
$service = Service::getService($db, intval($_GET['id']));
$categories = Category::getServiceCategories($db, $service->id);
$ratingsData = Review::getRatingsData($db, $service->id);
$comments = Review::getServiceReviews($db, $service->id);

output_header("Service", $session);
draw_messages();
draw_service_categories($categories);
draw_service_page($service, $ratingsData, $comments);
output_footer();