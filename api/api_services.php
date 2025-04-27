<?php 

declare(strict_types=1);

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/service.class.php';

$db = getDatabaseConnection();

$search = $_GET['query'] ?? '';
$services = Service::searchServices($db, $search);

echo json_encode($services);

?>