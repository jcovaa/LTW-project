<?php
declare(strict_types = 1);

require_once __DIR__ . '/database/connection.db.php';
require_once __DIR__ . '/database/service.class.php';
require_once __DIR__ . '/database/session.php';

require_once __DIR__ . '/templates/common.main.pages.php';
require_once __DIR__ . '/templates/freelancer_dashboard.tpl.php';



$session = Session::getInstance();
$freelancerId = $session->getUserId();
$db = getDatabaseConnection();
$services = Service::getFreelancerServices($db, $freelancerId);


output_header_dashboard("Freelancer Dashboard", $session);
draw_messages();
draw_dashboard_sidebar();
draw_services_section($services);
output_footer();

?>