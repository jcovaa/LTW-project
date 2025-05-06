<?php 

declare(strict_types=1);

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/service.class.php';

$db = getDatabaseConnection();

/*
$search = $_GET['query'] ?? '';
$ratingRange = $_GET['rating_range'] ?? null;

if ($ratingRange) {
   [$minRating, $maxRating] = explode('-', $ratingRange);
   $services = Service::filterServicesByRating($db, (int)$minRating, (int)$maxRating);
}
else {
   $services = Service::searchServices($db, $search);
}

echo json_encode($services);

*/

$filters = [
   'query' => $_GET['query'] ?? null,
   'rating_range' => $_GET['rating_range'] ?? null,
   'price_range' => $_GET['price_range'] ?? null,
];

$services = Service::filterServices($db, $filters);

echo json_encode($services);

?>