<?php 

declare(strict_types=1);
require_once 'templates/common_main_pages.php';

output_header("Service");

?>

<ul id="service_categories">
   <li>Programming and tech</li>
   <li>Design and creative</li>
   <li>Writing and translation</li>
   <li>Sales and marketing</li>
</ul>
<main>
   <section id="service_details">
      <header>
         <h2>I will code python applications, programs and scripts for you</h2>
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
   <section id="purchase_section">
      <div class="price_container">
         <p>Service Price</p>
         <p>€18.48</p>
      </div>
      <button class="purchase_button">Purchase Now</button>
   </section>
</main>

<?php output_footer() ?>