<?php

declare(strict_types=1);

// Change later to return the actual information from database
?>

<?php function draw_service_card() { ?>
   <article class="service_card">
      <a href="service.php">
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

<?php function draw_featured_services(): void { ?>
   <section id="featured_services">
      <header>
         <h2>Featured services</h2>
      </header>
      <?php 
         draw_service_card(); 
         draw_service_card();
         draw_service_card(); 
         draw_service_card(); 
      ?>
   </section>
<?php } ?>

<?php function draw_services(): void { ?>
   <section id="services">
      <?php 
         draw_service_card(); 
         draw_service_card(); 
         draw_service_card(); 
      ?>
   </section>
<?php } ?>

<?php function draw_service_categories(): void { ?>
   <ul id="service_categories">
      <li>Programming and tech</li>
      <li>Design and creative</li>
      <li>Writing and translation</li>
      <li>Sales and marketing</li>
   </ul>
<?php } ?>

<?php function draw_service_details(): void { ?>
   <section id="service_details">
      <header>
         <h2>I will code python applications, programs and scripts for you and explain how I did it</h2>
      </header>
      <div class="seller_info">
         <img src="images/default_profile.png" alt="Profile Picture"> 
         <p>Freelancer name</p>
      </div>
      <div class="service_description">
         <img src="https://picsum.photos/600/300?business" alt="">
         <p>I specialize in creating custom Python applications, scripts and automation solutions tailored to your specific needs. With years of experience in Python development, I can help you with any Python-related project, from simple scripts to complex applications.</p>
      </div>
   </section>
<?php } ?>

<?php function draw_ratings_section(): void { ?>
   <button class="contact_freelancer">Chat with the Freelancer</button>
   <section id="ratings">
      <header>
         <h3>Reviews</h3>
      </header>
      <div class="reviews_count">
         <p>82 reviews for this Service</p>
         <div class="overall_rating">
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <p>4.9</p>
         </div>
      </div>
      <div class="rating_bars">
         <div class="rating_bar">
            <p class="star_level">5 Stars</p>
            <div class="progress_container">
               <div class="progress-fill" style="width: 95%;"></div>
            </div>
            <p class="rating_count">78</p>
         </div>
         <div class="rating_bar">
            <p class="star_level">4 Stars</p>
            <div class="progress_container"> 
               <div class="progress-fill" style="width: 3%;"></div>
            </div>
            <p class="rating_count">3</p>
         </div>
         <div class="rating_bar">
            <p class="star_level">3 Stars</p>
            <div class="progress_container"> 
               <div class="progress-fill" style="width: 2%;"></div>
            </div>
            <p class="rating_count">1</p>
         </div>
         <div class="rating_bar">
            <p class="star_level">2 Stars</p>
            <div class="progress_container"> 
               <div class="progress-fill" style="width: 0%;"></div>
            </div>
            <p class="rating_count">0</p>
         </div>
         <div class="rating_bar">
            <p class="star_level">1 Star</p>
            <div class="progress_container"> 
               <div class="progress-fill" style="width: 0%;"></div>
            </div>
            <p class="rating_count">0</p>
         </div>
      </div>
   </section>
<?php } ?>

<?php function draw_comments_section(): void { ?>
   <section id="comments">
      <header>
         <h3>Comments</h3>
      </header>
      <article id="comment_form">
         <textarea placeholder="Write your review here..."></textarea>
            <button class="submit_comment">Submit Review</button>
         </textarea>
      </article>
   </section>
   <section id="comments_list">
      <article class="comment">
         <header>
            <img src="images/default_profile.png" alt="Profile Picture"> 
            <p>Freelancer name</p>
         </header>
         <p class="number_of_stars">5</p>
         <p class="comment_text">Samridh has done an absolutely amazing job! I can't believe how quickly they delivered my work—within just 2-3 hours! It made my task so much easier and saved me a lot of time. On top of their incredible efficiency, Samridh's polite and professional behavior truly stood out. Thank you so, so much for your excellent service! Highly recommend!</p>
      </article>
   </section>
<?php } ?>

<?php function draw_purchase_section() { ?>
   <section id="purchase_section">
      <div class="price_container">
         <p>Service Price</p>
         <p>€18.48</p>
      </div>
      <button class="purchase_button">Purchase Now</button>
   </section>
<?php } ?>

<?php function draw_service_page() { ?>
   <main id="service_page">
      <?php 
         draw_service_details(); 
         draw_ratings_section(); 
         draw_comments_section(); 
         draw_purchase_section(); 
      ?>
   </main>
<?php } ?>