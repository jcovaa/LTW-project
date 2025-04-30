<?php

declare(strict_types=1);

?>

<?php function output_header($title, $session): void
{ ?>
   <!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="css/styles.css">
      <script src="javascript/script.js" defer></script>
      <title>My Web Page</title>
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
               <?php if (Session::getInstance()->getUser()): ?>
                  <?php drawLogoutForm(); ?>
               <?php else: ?>
                  <li><button onclick="window.location.href='login.php'">Login</button></li>
                  <li><button onclick="window.location.href='register.php'">Sign Up</button></li>
               <?php endif; ?>
            </ul>
         </nav>
      </header>
   <?php } ?>

   <!-- Feito para verificar se era possivel fazer logout -->
   <?php function drawLogoutForm()
   { ?>
      <form action="../actions/action.logout.php" method="post" class="login">
         <?= Session::getInstance()->getUser()->username ?>
         <button type="submit">Logout</button>
      </form>
      <?php } ?>

<?php function output_footer(): void { ?>
         <footer>
            <p>Name of the app</p>
            <p>name, date</p>
         </footer>
      </body>
   </html>
<?php } ?>