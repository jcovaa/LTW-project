<?php

declare(strict_types=1);

// Change later to return the actual information from database
?>

<?php function output_service_card() { ?>
   <article class="service_card">
      <a href="index.php">
         <img src="https://picsum.photos/600/300?business" alt="">
      </a>
      <div class="service_info">
         <div class="profile">
            <img src="images/default_profile.png" alt="Profile Picture"> 
            <p>Freelancer name</p>
         </div>
         <a href="service.php">Title of the service</a>
         <p>Rating</p>
         <p>Price</p>
      </div>
   </article>
<?php } ?>