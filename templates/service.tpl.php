<?php

declare(strict_types=1);

?>

<?php function draw_service_card(Service $service) { ?>
   <article class="service_card">
      <a href="service.php?id=<?=$service->id ?>">
         <img src="https://picsum.photos/200?<?=$service->id ?>" alt="service image">
      </a>
      <div class="service_info">
         <div class="profile">
            <img src="images/default_profile.png" alt="Profile Picture"> 
            <p><?=$service->freelancerName ?></p>
         </div>
         <a href="service.php?id=<?=$service->id ?>"><?=$service->name ?></a>
         <p><?=$service->avgRating ?></p>
         <p>Price: €<?=number_format($service->price, 2) ?></p>
      </div>
   </article>
<?php } ?>

<?php function draw_featured_services(array $featureServices): void { ?>
   <section id="featured_services">
      <header>
         <h2>Featured Services</h2>
      </header>
      <?php 
         foreach ($featureServices as $service) {
            draw_service_card($service); 
         }
      ?>
   </section>
<?php } ?>

<?php function draw_services(array $services): void { ?>
   <section id="services">
      <?php
         foreach ($services as $service) {
            draw_service_card($service); 
         }
      ?>
   </section>
<?php } ?>

<?php function draw_service_categories(array $categories): void { ?>
   <ul id="service_categories">
      <?php foreach ($categories as $category) { ?>
         <li><?=$category->name ?></li>
      <?php } ?>
   </ul>
<?php } ?>

<?php function draw_service_details(Service $service): void { ?>
   <section id="service_details">
      <header>
         <h2><?=$service->name ?></h2>
      </header>
      <div class="seller_info">
         <img src="images/default_profile.png" alt="Profile Picture"> 
         <p><?=$service->freelancerName ?></p>
      </div>
      <div class="service_description">
         <img src="https://picsum.photos/600/300?<?=$service->id ?>" alt="">
         <p><?=$service->description ?></p>
      </div>
   </section>
<?php } ?>

<?php function draw_ratings_section(array $ratingsData): void { ?>
    <button class="contact_freelancer">Chat with the Freelancer</button>
    <section id="ratings">
        <header>
            <h3>Reviews</h3>
        </header>
        <div class="reviews_count">
            <p><?= $ratingsData['totalReviews'] ?> reviews for this Service</p>
            <div class="overall_rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span class="star"><?= $i <= $ratingsData['overallRating'] ? '★' : '☆' ?></span>
                <?php endfor; ?>
                <p><?= $ratingsData['overallRating'] ?></p>
            </div>
        </div>
        <div class="rating_bars">
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <div class="rating_bar">
                    <p class="star_level"><?= $i ?> Stars</p>
                    <div class="progress_container">
                        <div class="progress-fill" style="width: <?= $ratingsData['percentages'][$i] ?>%;"></div>
                    </div>
                    <p class="rating_count"><?= $ratingsData['ratingCounts'][$i] ?></p>
                </div>
            <?php endfor; ?>
        </div>
    </section>
<?php } ?>

<?php function draw_comments_section(): void { ?>
   <section id="comments">
      <header>
         <h3>Comments</h3>
      </header>
      <article id="comment_form">
         <div class="star_rating">
            <p>Your Rating:</p>
            <div class="stars">
               <input type="radio" id="star5" name="rating" value="5">
               <label for="star5" class="star">★</label>
               <input type="radio" id="star4" name="rating" value="4">
               <label for="star4" class="star">★</label>
               <input type="radio" id="star3" name="rating" value="3">
               <label for="star3" class="star">★</label>
               <input type="radio" id="star2" name="rating" value="2">
               <label for="star2" class="star">★</label>
               <input type="radio" id="star1" name="rating" value="1">
               <label for="star1" class="star">★</label>
            </div>
         </div>
         <textarea placeholder="Write your review here..."></textarea>
         <button class="submit_comment">Submit Review</button>
      </article>
   </section>
   <section id="comments_list">
      <article class="comment">
         <header>
            <img src="images/default_profile.png" alt="Profile Picture"> 
            <p>client name</p>
         </header>
         <p class="number_of_stars">5</p>
         <p class="comment_text">Samridh has done an absolutely amazing job! I can't believe how quickly they delivered my work—within just 2-3 hours! It made my task so much easier and saved me a lot of time. On top of their incredible efficiency, Samridh's polite and professional behavior truly stood out. Thank you so, so much for your excellent service! Highly recommend!</p>
      </article>
   </section>
<?php } ?>

<?php function draw_purchase_section(Service $service) { ?>
   <section id="purchase_section">
      <div class="price_container">
         <p>Service Price</p>
         <p><?=$service->price ?>€</p>
      </div>
      <button class="purchase_button">Purchase Now</button>
   </section>
<?php } ?>

<?php function draw_service_page(Service $service, array $ratingsData) { ?>
   <main id="service_page">
      <?php 
         draw_service_details($service); 
         draw_ratings_section($ratingsData); 
         draw_comments_section(); 
         draw_purchase_section($service); 
      ?>
   </main>
<?php } ?>