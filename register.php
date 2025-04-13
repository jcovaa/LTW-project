<?php 

declare(strict_types=1);
require_once 'templates/common_login_pages.php';

output_header("Register");

?>

      <main>
      <form action="">
         <h1>Create an account</h1>
         <div class="input_box">
            <input type="text" placeholder="username" required>
         </div>
         <div class="input_box">
            <input type="text" placeholder="Name" required>
         </div>
         <div class="input_box">
            <input type="text" placeholder="Email" required>
            <i class='bx bxs-user'></i>
         </div>
         <div class="input_box">   
            <input type="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt' ></i>
         </div>
         <button type="submit">Register</button>
         <div class="link">
            <p>Already have an account? <a href="login.php">Login</a></p>
         </div>
      </form>
      </main>
      <footer>
         <p>Name of the app</p>
         <p>name, date</p>
      </footer>
   </body>
</html>