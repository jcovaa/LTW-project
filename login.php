<?php 

declare(strict_types=1);
require_once 'templates/common_login_pages.php';

output_header("Login");

?>

      <main id="authentication_page">
      <form action="">
         <h1>Login</h1>
         <div class="input_box">
            <input type="text" placeholder="Email" required>
            <i class='bx bxs-user'></i>
         </div>
         <div class="input_box">   
            <input type="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt' ></i>
         </div>
         <button type="submit">Login</button>
         <div class="link">
            <p>Don't have an account? <a href="register.php">Register</a></p>
         </div>
      </form>
      </main>  
<?php output_footer(); ?>