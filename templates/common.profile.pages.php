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
      <link rel="stylesheet" href="css/profile.css">
      <link rel="stylesheet" href="css/styles.css">
      <title><?=$title?></title>
   </head>
   <body>
      <header>
         <h1 id="logo"><a href="index.php">Title</a></h1>
         <form class="search_bar" action="search.php" method="get">
            <input type="text" name="query" placeholder="Search...">
            <button class="fa fa-search" type="submit"></button>
         </form>
         <nav id="nav_menu">
            <ul>
               <li><button onclick="window.location.href='add_service.php'">Add a service</button></li>
               <li><button onclick="window.location.href='login.php'">Login</button></li>
               <li><button onclick="window.location.href='register.php'">SIGNUP</button></li>
            </ul>
         </nav>
      </header>
<?php } ?>

<?php function draw_profile_sidebar(): void { ?>
    <nav id="sidebar_menu" class="nav_menu">
        <ul>
            <li><a href="/myorders.php">Your Orders</a></li>
            <li><a href="/myservices.php">Your Services</a></li>
            <li><a href="/edit_profile.php">Edit Profile</a></li>
            <li><a href="/logout.php">Log Out</a></li>
        </ul>
    </nav>
<?php } ?>

<?php function draw_profile_links(): void { ?>
    <nav id="links_menu" class="nav_menu">
        <ul>
            <li><a href="https://twitter.com">Twitter</a></li>
            <li><a href="https://facebook.com">Facebook</a></li>
            <li><a href="https://instagram.com">Instagram</a></li>
        </ul>
    </nav>
<?php } ?>

<?php function draw_profile(): void { ?>
    <div class="profile">
        <div class="profile-header">
            <img src="images/default_profile.png" alt="Profile Picture" class="profile-picture">
            <div class="profile-info">
                <div class="profile-name">Joao M.</div>
                <div class="profile-rating">4.97</div>
            </div>
        </div>
        <div class="profile-description">
            <p>Teste teste teste teste teste teste teste Teste teste teste teste.</p>
        </div>
    </div>
<?php } ?>

<?php function draw_profile_edit(): void { ?>
    <main id="profile_form">
      <form action="">
        <h1>Edit Profile</h1>
         <div class="input_box">   
            <input type="text" placeholder="Name" required>
         </div>
         <div class="input_box">  
            <input type="text" placeholder="Username" required>
         </div>
         <div class="input_box">
            <textarea placeholder='Tell us about you' maxlength='1000'></textarea>
         </div>
         
         <div class="input_image">
            <p>Avatar</p>
            <input type="file" id="miniature" name="miniature" accept=".jpeg,.jpg,.png">
        </div>

         <button type="submit">Edit Profile</button>
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



