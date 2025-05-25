<?php

#declare(strict_types=1);

?>

<?php function output_header_profile($title, $session): void
{ ?>
   <!DOCTYPE html>
   <html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="css/styles.css">
      <link rel="stylesheet" href="css/freelancer_dashboard.css">
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

<?php function draw_profile_sidebar(): void { ?>
    <nav id="sidebar_menu" class="nav_menu">
        <ul>
            <li><a href="/edit_profile.php">Edit Profile</a></li>
        </ul>
    </nav>
<?php } ?>

<?php function draw_profile(User $user): void { ?>
   <div class="profile">
   <div class="profile-header">
      <img src="<?= htmlspecialchars($user->imageUrl) ?>" alt="Profile Picture" class="profile-picture">
      <div class="profile-info">
         <div class="profile-name"><?= htmlspecialchars($user->name) ?></div>
      </div>
   </div>
   </div>
<?php } ?>

<?php function draw_profile_edit(User $user, Session $session): void { ?>
<main id="profile_form">
  <form action="actions/action.edit_profile.php" method="post" enctype="multipart/form-data">
    <h1>Edit Profile</h1>
    <input type="hidden" name="csrf" value="<?= $session->getCSRFToken() ?>">

    <div class="input_box">   
      <input type="text" name="name" placeholder="Name" required value="<?=htmlspecialchars($user->name)?>">
    </div>
    <div class="input_box">  
      <input type="text" name="username" placeholder="Username" required value="<?=htmlspecialchars($user->username)?>">
    </div>         
    <div class="input_image">
      <p>Profile Picture</p>
      <input type="file" name="profile_picture" accept=".jpeg,.jpg,.png">
    </div>

    <button type="submit">Save</button>
  </form>
</main>
<?php } ?>      




