<?php 

declare(strict_types=1);
require_once 'templates/common_main_pages.php';

output_header("Home");

?>
      <nav id="filter_section">
         <button id="category">category<i class="fa fa-angle-down"></i></button>
         <button id="price">price<i class="fa fa-angle-down"></i></button>
         <button id="rating">rating<i class="fa fa-angle-down"></i></button>
      </nav>
      <section id="featured_services">
         <header>
            <h2>Featured services</h2>
         </header>
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
      </section>
      <section id="services">
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
      </section>
      <footer>
         <p>Name of the app</p>
         <p>name, date</p>
      </footer>
   </body>
</html>

