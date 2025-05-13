<?php
declare(strict_types = 1);

require_once __DIR__ . '/database/connection.db.php';
require_once __DIR__ . '/database/service.class.php';
require_once __DIR__ . '/database/session.php';

require_once __DIR__ . '/templates/common.freelancer_dashboard.page.php';



$session = Session::getInstance();
$freelancerId = $session->getUserId();
$db = getDatabaseConnection();
$services = Service::getFreelancerServices($db, $freelancerId);


output_header("Freelancer Dashboard", $session);
draw_dashboard($services);
output_footer();

?>