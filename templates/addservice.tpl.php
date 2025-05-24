<?php

declare(strict_types=1);

?>

<?php function output_header_($title, $session): void
{ ?>
   <!DOCTYPE html>
   <html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="css/styles.css">
      <link rel="stylesheet" href="css/add_service.css">
      <script src="javascript/script.js" defer></script>
      <title><?= htmlspecialchars($title) ?></title>
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

   <?php function draw_service_form($categories): void
   { ?>
      <main id="form_page">
         <form action="actions/action.create_service.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf" value="<?= Session::getInstance()->getCSRFToken() ?>">
            <h1>Add your service</h1>
            <div class="input_box">
               <input type="text" placeholder="Service Name" name="name" required>
            </div>
            <div class="input_box">
               <textarea placeholder='Description (20-1000 characters)' name="description" maxlength='1000' minlength='20'></textarea>
            </div>

            <div class="custom-select">
               <select id="category" name="category" required>
                  <?php foreach ($categories as $category) { ?>
                     <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
                  <?php } ?>
               </select>
            </div>

            <div class="input_box">
               <input type="text" placeholder="Estimated Delivery Time (days)" name="delivery" required>
            </div>
            <div class="input_box">
               <input type="text" placeholder="Price (EUR)" name="price" required>
            </div>

            <div class="input_image">
               <input type="file" id="image" name="image" accept=".jpeg,.jpg,.png">
            </div>

            <button type="submit">List Service</button>
            <button type="reset" value="Reset">Clear All</button>

         </form>
      </main>
   <?php } ?>