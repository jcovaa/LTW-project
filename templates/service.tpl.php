<?php

declare(strict_types=1);

?>

<?php function draw_filter_section(array $categories): void
{ ?>
   <nav id="filter_section">
      <div class="dropdown">
         <button id="category" class="dropdown_button">Category<i class="fa fa-angle-down"></i></button>
         <ul class="dropdown_menu category_menu">
            <?php foreach ($categories as $category) { ?>
               <li>
                  <label>
                     <input type="radio" name="category" value="<?= $category->id ?>" onchange="applyCategoryFilter()"> <?= htmlspecialchars($category->name) ?>
                  </label>
               </li>
            <?php } ?>
            <button class="clear_button" data-clear="category" onclick="clearCategoryFilter()">Clear</button>
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

<?php function draw_service_card(Service $service)
{ ?>
   <article class="service_card">
      <a href="service.php?id=<?= $service->id ?>">
         <img src="<?= htmlspecialchars($service->imageUrl) ?>" alt="service image">
      </a>
      <div class="service_info">
         <div class="profile">
            <img src="<?= htmlspecialchars($service->freelancerImageUrl) ?>" alt="Profile Picture">
            <p><?= htmlspecialchars($service->freelancerName) ?></p>
         </div>
         <a href="service.php?id=<?= $service->id ?>"><?= htmlspecialchars($service->name) ?></a>
         <p><?= htmlspecialchars((string)$service->avgRating) ?></p>
         <p>Price: €<?= number_format($service->price, 2) ?></p>
      </div>
   </article>
<?php } ?>

<?php function draw_featured_services(array $featureServices): void
{ ?>
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

<?php function draw_services(array $services): void
{ ?>
   <section id="services">
      <?php
      if (isset($_GET['query']) && !empty($_GET['query'])) {
         $query = $_GET['query'];
         $services = array_filter($services, function ($service) use ($query) {
            return stripos($service->name, $query) !== false;
         });
      }

      if (isset($_GET['rating_range']) && !empty($_GET['rating_range'])) {
         [$minRating, $maxRating] = explode('-', $_GET['rating_range']);
         $services = array_filter($services, function ($service) use ($minRating, $maxRating) {
            return $service->avgRating >= (float)$minRating && $service->avgRating <= (float)$maxRating;
         });
      }

      if (isset($_GET['price_range']) && !empty($_GET['price_range'])) {
         $priceRange = $_GET['price_range'];
         if ($priceRange === '>500') {
            $services = array_filter($services, function ($service) {
               return $service->price > 500;
            });
         } else {
            [$minPrice, $maxPrice] = explode('-', $priceRange);
            $services = array_filter($services, function ($service) use ($minPrice, $maxPrice) {
               return $service->price >= (float)$minPrice && $service->price <= (float)$maxPrice;
            });
         }
      }

      if (isset($_GET['category']) && $_GET['category'] !== 'all') {
         $categoryId = (int)$_GET['category'];
         $services = array_filter($services, function ($service) use ($categoryId) {
            return in_array($categoryId, $service->categoryIds);
         });
      }

      foreach ($services as $service) {
         draw_service_card($service);
      }
      ?>
   </section>
<?php } ?>

<?php function draw_service_categories(array $categories): void
{ ?>
   <ul id="service_categories">
      <?php foreach ($categories as $category) { ?>
         <li><?= htmlspecialchars($category->name) ?></li>
      <?php } ?>
   </ul>
<?php } ?>

<?php function draw_service_details(Service $service): void
{ ?>
   <section id="service_details">
      <header>
         <h2><?= htmlspecialchars($service->name) ?></h2>
      </header>
      <div class="seller_info">
         <img src="<?= htmlspecialchars($service->freelancerImageUrl) ?>" alt="Profile Picture">
         <p><?= htmlspecialchars($service->freelancerName) ?></p>
      </div>
      <div class="service_description">
         <img src="<?= htmlspecialchars($service->imageUrl) ?>" alt="service image">
         <p><?= htmlspecialchars($service->description) ?></p>
      </div>
   </section>
<?php } ?>

<?php function draw_ratings_section(array $ratingsData, $service): void
{ ?>
   <?php if (Session::getInstance()->isLoggedIn() && (Session::getInstance()->getUserId() !== $service->freelancerId)) { ?>
      <button class="contact_freelancer">Chat with the Freelancer</button>
   <?php } ?>
   <section id="ratings">
      <header>
         <h3>Reviews</h3>
      </header>
      <div class="reviews_count">
         <p><?= htmlspecialchars((string)$ratingsData['totalReviews']) ?> reviews</p>
         <div class="overall_rating">
            <?php for ($i = 1; $i <= 5; $i++) { ?>
               <span class="star"><?= $i <= $ratingsData['overallRating'] ? '★' : '☆' ?></span>
            <?php } ?>
            <p><?= htmlspecialchars((string)$ratingsData['overallRating']) ?></p>
         </div>
      </div>
      <div class="rating_bars">
         <?php for ($i = 5; $i >= 1; $i--) { ?>
            <div class="rating_bar">
               <p class="star_level"><?= $i ?> Stars</p>
               <div class="progress_container">
                  <div class="progress-fill" style="width: <?= $ratingsData['percentages'][$i] ?>%;"></div>
               </div>
               <p class="rating_count"><?= htmlspecialchars((string)$ratingsData['ratingCounts'][$i]) ?></p>
            </div>
         <?php } ?>
      </div>
   </section>
<?php } ?>

<?php function draw_comments_section(array $comments, $service): void
{ ?>
   <section id="comments">
      <header>
         <h3>Comments</h3>
      </header>

      <?php if (Session::getInstance()->isLoggedIn() && (Session::getInstance()->getUserId() !== $service->freelancerId)): ?>
         <article id="comment_form">
            <form action="actions/action.submit_review.php" method="post">
               <input type="hidden" name="csrf" value="<?= Session::getInstance()->getCSRFToken() ?>">
               <input type="hidden" name="service_id" value="<?= $service->id ?>">
               <div class="star_rating">
                  <p>Your Rating:</p>
                  <div class="stars">
                     <input type="radio" id="star5" name="rating" value="5" required>
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
               <textarea name="comment" placeholder="Write your review here..." required></textarea>
               <button type="submit" class="submit_comment">Submit Review</button>
            </form>
         </article>
      <?php elseif (!Session::getInstance()->isLoggedIn()): ?>
         <p class="login_prompt">Please <a href="login.php">log in</a> to write a review.</p>
      <?php endif; ?>
   </section>
   <section id="comments_list">
      <?php if (!empty($comments)) { ?>
         <?php foreach ($comments as $comment) { ?>
            <article class="comment">
               <header>
                  <img src="<?= htmlspecialchars($service->freelancerImageUrl) ?>" alt="Profile Picture">
                  <p><?= htmlspecialchars($comment->clientName) ?></p>
               </header>
               <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++): ?>
                     <span class="star"><?= $i <= $comment->rating ? '★' : '☆' ?></span>
                  <?php endfor; ?>
               </div>
               <p class="comment_text"><?= htmlspecialchars($comment->comment) ?></p>
            </article>
         <?php } ?>
      <?php } else { ?>
         <p class="no_comments">No reviews yet.</p>
      <?php } ?>
   </section>
<?php } ?>

<?php function draw_purchase_section(Service $service)
{ ?>
   <section id="purchase_section">
      <div class="price_container">
         <p>Service Price</p>
         <p><?= htmlspecialchars((string)$service->price) ?>€</p>
      </div>
      <button class="purchase_button" onclick="window.location.href='payment.php?service_id=<?= $service->id ?>&type=order'">Purchase Now</button>
   </section>
<?php } ?>

<?php function draw_chat_container(int $freelancerId): void
{ ?>
   <?php if (Session::getInstance()->isLoggedIn()) { ?>
      <section id="chat_container" class="hidden">
         <header>
            <h3>Chat</h3>
            <button id="close_chat">×</button>
         </header>
         <div id="chat_messages">
            <!-- Chat messages will be dynamically loaded here -->
         </div>
         <form id="message_form">
            <input type="hidden" id="receiver_id" value="<?= $freelancerId ?>">
            <textarea id="message_input" placeholder="Type your message..." required></textarea>
            <button type="submit">Send</button>
         </form>
      </section>
   <?php } ?>
<?php } ?>

<?php function draw_service_page(Service $service, array $ratingsData, array $comments): void
{ ?>
   <main id="service_page">
      <?php
      draw_service_details($service);
      draw_ratings_section($ratingsData, $service);
      draw_comments_section($comments, $service);
      if (Session::getInstance()->getUserId() !== $service->freelancerId) {
         draw_purchase_section($service);
      }
      draw_chat_container($service->freelancerId);
      ?>
   </main>
<?php } ?>