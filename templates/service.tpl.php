<?php

declare(strict_types=1);

?>

<?php function draw_filter_section(array $categories): void { ?>
   <nav id="filter_section">
      <div class="dropdown">
         <button id="category" class="dropdown_button">Category<i class="fa fa-angle-down"></i></button>
         <ul class="dropdown_menu category_menu">
            <li>
               <label>
                  <input type="radio" name="category" value="all">All Categories
               </label>
            </li>
            <?php foreach ($categories as $category) { ?>
               <li>
                  <label>
                     <input type="radio" name="category" value="<?= $category->id ?>"> <?= $category->name ?>
                  </label>
               </li>
            <?php } ?>
         </ul>
      </div>
      <div class="dropdown">
         <button id="price" class="dropdown_button">Price<i class="fa fa-angle-down"></i></button>
         <ul class="dropdown_menu price_menu">
            <li>
               <label>
                  <input type="radio" name="price_range" value="0-50" onchange="applyPriceFilter()">
                  0€ - 50€
               </label>
            </li>
            <li>
               <label>
                  <input type="radio" name="price_range" value="50-100" onchange="applyPriceFilter()">
                  50€ - 100€
               </label>
            </li>
            <li>
               <label>
                  <input type="radio" name="price_range" value="100-200" onchange="applyPriceFilter()">
                  100€ - 200€
               </label>
            </li>
            <li>
               <label>
                  <input type="radio" name="price_range" value="200-500" onchange="applyPriceFilter()">
                  200€ - 500€
               </label>
            </li>
            <li>
               <label>
                  <input type="radio" name="price_range" value=">500" onchange="applyPriceFilter()">
                  > 500€
               </label>
            </li>
            <button class="clear_button" data-clear="price" onclick="clearPriceFilter()">Clear</button>
         </ul>
      </div>
      <div class="dropdown">
         <button id="rating">Rating<i class="fa fa-angle-down"></i></button>
         <ul class="dropdown_menu rating_menu">
            <li>
               <label>
                  <input type="radio" name="rating_range" value="0-1" onchange="applyRatingFilter()"> 0 - 1 Stars
               </label>
            </li>
            <li>
               <label>
                  <input type="radio" name="rating_range" value="1-2" onchange="applyRatingFilter()"> 1 - 2 Stars
               </label>
            </li>
            <li>
               <label>
                  <input type="radio" name="rating_range" value="2-3" onchange="applyRatingFilter()"> 2 - 3 Stars
               </label>
            </li>
            <li>
               <label>
                  <input type="radio" name="rating_range" value="3-4" onchange="applyRatingFilter()"> 3 - 4 Stars
               </label>
            </li>
            <li>
               <label>
                  <input type="radio" name="rating_range" value="4-5" onchange="applyRatingFilter()"> 4 - 5 Stars
               </label>
            </li>
            <button class="clear_button" data-clear="rating" onclick="clearRatingFilter()">Clear</button>
         </ul>
      </div>
   </nav>
<?php } ?>

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
         if (isset($_GET['query']) && !empty($_GET['query'])) {
            $query = $_GET['query'];
            $services = array_filter($services, function($service) use ($query) {
               return stripos($service->name, $query) !== false;
            });
         }

         if (isset($_GET['rating_range']) && !empty($_GET['rating_range'])) {
            [$minRating, $maxRating] = explode('-', $_GET['rating_range']);
            $services = array_filter($services, function($service) use ($minRating, $maxRating) {
               return $service->avgRating >= (float)$minRating && $service->avgRating <= (float)$maxRating;
            });
         }

         if (isset($_GET['price_range']) && !empty($_GET['price_range'])) {
            $priceRange = $_GET['price_range'];
            if ($priceRange === '>500') {
               $services = array_filter($services, function($service) {
                  return $service->price > 500;
               });
            } else {
               [$minPrice, $maxPrice] = explode('-', $priceRange);
               $services = array_filter($services, function($service) use ($minPrice, $maxPrice) {
                  return $service->price >= (float)$minPrice && $service->price <= (float)$maxPrice;
               });
            }
         }

         if (isset($_GET['category']) && $_GET['category'] !== 'all') {
            $categoryId = (int)$_GET['category'];
            $services = array_filter($services, function($service) use ($categoryId) {
               return $service->categoryId === $categoryId;
            });
         }

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
         <img src="https://picsum.photos/200?<?=$service->id ?>" alt="service image">
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
            <p><?= $ratingsData['totalReviews'] ?> reviews</p>
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

<?php function draw_comments_section(array $comments): void { ?>
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
      <?php foreach($comments as $comment) { ?>
         <article class="comment">
            <header>
               <img src="images/default_profile.png" alt="Profile Picture"> 
               <p><?= $comment->clientName ?></p>
            </header>
            <p class="number_of_stars"><?= $comment->rating ?></p>
            <p class="comment_text"><?= $comment->comment ?></p>
         </article>
      <?php } ?>
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

<?php function draw_service_page(Service $service, array $ratingsData, array $comments): void { ?>
   <main id="service_page">
      <?php 
         draw_service_details($service); 
         draw_ratings_section($ratingsData); 
         draw_comments_section($comments); 
         draw_purchase_section($service); 
      ?>
   </main>
<?php } ?>