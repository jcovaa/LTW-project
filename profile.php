<?php
declare(strict_types = 1);

require_once __DIR__ . '/templates/common.profile.pages.php';


output_header("Profile");
draw_profile_sidebar();
draw_profile_links();
draw_profile();
output_footer();

?>