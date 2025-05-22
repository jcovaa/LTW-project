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
      <link rel="icon" type="image/x-icon" href="favicon.ico">
      <script src="javascript/script.js" defer></script>
      <title><?=htmlspecialchars($title) ?></title>
   </head>

   <body>
      <header>
         <h1 id="logo"><a href="index.php">lancer</a></h1>
         <form class="search_bar" action="search.php" method="get">
            <input type="text" name="query" placeholder="Search...">
            <button class="fa fa-search" type="submit"></button>
         </form>
         <nav id="nav_menu">
            <button id="menu_toggle" class="fa fa-bars"></button>
            <ul>
               <?php if ($session->getUser()) : ?>
                  <li><button onclick="window.location.href='add_service.php'">Add a service</button></li>
                  <li><button onclick="window.location.href='my_services.php'">Dashboard</button>
                  <?php endif; ?>
                  <?php if ($session->getUser()) drawLogoutForm($session);
                  else drawLoginForm(); ?>
            </ul>
         </nav>
      </header>
<?php } ?>

   
<?php function draw_messages() { ?>
   <section id="messages">
      <?php
      $session = Session::getInstance();
      foreach ($session->getMessages() as $message) { ?>
         <article class="<?= htmlspecialchars($message['type']) ?>">
            <?= htmlspecialchars($message['text']) ?>
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
         </article>
      <?php } ?>
   </section>
<?php } ?>



   <?php function drawLogoutForm($session)
   { ?>
      <li><a href="profile.php"><?= htmlspecialchars($session->getUser()->username) ?></a></li>
      <li>
         <form action="../actions/action.logout.php" method="post" style="display: inline;">
            <input type="hidden" name="csrf" value="<?=$session->getCSRFToken()?>">
            <button type="submit">Logout</button>
         </form>
      </li>
   <?php } ?>

   <?php function drawLoginForm()
   { ?>
      <li><button onclick="window.location.href='login.php'">Login</button></li>
      <li><button onclick="window.location.href='register.php'">Sign Up</button></li>
   <?php } ?>



   <?php function output_footer(): void
   { ?>
      <footer>
         <p>lancer</p>
         <p>lancer ltw 2025</p>
      </footer>
   </body>

   </html>
<?php } ?>