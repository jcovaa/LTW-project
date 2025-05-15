<?php
declare(strict_types = 1);

require_once __DIR__ . '/database/connection.db.php';
require_once __DIR__ . '/database/service.class.php';
require_once __DIR__ . '/database/order.class.php';
require_once __DIR__ . '/database/session.php';

require_once __DIR__ . '/templates/freelancer_dashboard.tpl.php';


$session = Session::getInstance();
$freelancerId = $session->getUserId();
$db = getDatabaseConnection();

$serviceId = intval($_GET['service_id']);
$service = Service::getService($db, $serviceId);
$orders = Order::getOrdersByService($db, $serviceId);


output_header("Freelancer Dashboard", $session);
draw_dashboard_sidebar();
draw_service_orders($service, $orders);
output_footer();

?>