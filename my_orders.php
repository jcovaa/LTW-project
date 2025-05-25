<?php
declare(strict_types = 1);

require_once __DIR__ . '/database/connection.db.php';

require_once __DIR__ . '/database/order.class.php';
require_once __DIR__ . '/database/session.php';

require_once __DIR__ . '/templates/freelancer_dashboard.tpl.php';
require_once __DIR__ . '/templates/common.main.pages.php';



$session = Session::getInstance();
$clientId = $session->getUserId();
$db = getDatabaseConnection();
$orders = Order::getOrdersByClient($db, $clientId);




output_header_dashboard("Freelancer Dashboard", $session);
draw_messages();
draw_dashboard_sidebar($session);
draw_orders_section($orders);
output_footer();
