<?php

declare(strict_types=1);

function get_all_services(PDO $db): array {
   // The User and Service table has some equal column names
   $stmt = $db->prepare("
      SELECT
         Service.ServiceId AS service_id,
         Service.Name AS service_name,
         User.UserId AS user_id,
         User.Username, 
      FROM Service
      JOIN User ON Service.FreelancerID = User.UserId   
   ");
   $stmt->execute();
   $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $services;
}

?>