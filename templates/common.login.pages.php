<?php

declare(strict_types=1);

?>

<?php function output_header($title): void { ?>
   <!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="css/login.css">
      <link rel="stylesheet" href="css/styles.css">
      <title><?=$title?></title>
   </head>
   <body>
      <header>
         <h1 id="logo"><a href="index.php">Title</a></h1>
         <nav id="nav_menu">
            <ul>
               <li><button onclick="window.location.href='add_service.php'">Add a service</button></li>
               <li><button onclick="window.location.href='login.php'">Login</button></li>
               <li><button onclick="window.location.href='register.php'">Sign Up</button></li>
            </ul>
         </nav>
      </header>
<?php } ?>

<?php function draw_login_form(): void { ?>
   <main id="authentication_page">
      <form action="../actions/action.login.php" method="POST">
         <h1>Login</h1>
         <div class="input_box">
            <input type="text" name="email" placeholder="Email" required>
            <i class='bx bxs-user'></i>
         </div>
         <div class="input_box">   
            <input type="password" name="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt' ></i>
         </div>
         <button type="submit">Login</button>
         <div class="link">
            <p>Don't have an account? <a href="register.php">Register</a></p>
         </div>
      </form>
   </main>  
<?php } ?>

<?php function draw_register_form(): void { ?>
   <main id="authentication_page">
      <form action="../actions/action.register.php" method="POST">
         <h1>Create an account</h1>
         <div class="input_box">
            <input type="text" name="username" placeholder="Username" required>
         </div>
         <div class="input_box">
            <input type="text" name="name" placeholder="Name" required>
         </div>
         <div class="input_box">
            <input type="text" name="email" placeholder="Email" required>
            <i class='bx bxs-user'></i>
         </div>
         <div class="input_box">   
            <input type="password" name="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt' ></i>
         </div>
         <button type="submit">Register</button>
         <div class="link">
            <p>Already have an account? <a href="login.php">Login</a></p>
         </div>
      </form>
   </main>
<?php } ?>

<?php function output_footer(): void { ?>
   <footer>
         <p>Name of the app</p>
         <p>name, date</p>
      </footer>
   </body>
</html>
<?php } ?>   