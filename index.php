<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Web Page</title>
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="styles.css">
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
               <li><a href="add_service.php">Add a service</a></li>
               <li><a href="login.php">Login</a></li>
               <li><a href="register.php">SIGNUP</a></li>
            </ul>
         </nav>
         <!--
         <div id="nav_menu">
            <form class="add_service" action="add_service.php" method="pos">
               <input type="button" value="Add a Service" onclick="window.location.href='add_service.php'">
            </form>
            <div id="user_links">
               <input type="button" value="Login" onclick="window.location.href='login.php'">
               <input type="button" value="Sign Up" onclick="window.location.href='register.php'">
            </div>
         </div>
         -->
      </header>
      <nav id="filter_section">
         <button id="category">category</button>
         <button id="price">price</button>
         <button id="rating">rating</button>
      </nav>
      <section id="featured_services">
         <header>
            <h2>Featured services</h2>
         </header>
         <article class="service_card">
            <a href="index.php"><img src="https://picsum.photos/600/300?business" alt=""></a>
            <p>Example service</p>
            <img src="images/default_profile.png" alt="Profile Picture">
            <a id ="profile_name" href="index.php">Example name</a>
         </article>
         <article class="service_card">
            <a href="index.php"><img src="https://picsum.photos/600/300?business" alt=""></a>
            <p>Example service</p>
            <img src="images/default_profile.png" alt="Profile Picture">
            <a id ="profile_name" href="index.php">Example name</a>
         </article>
         <article class="service_card">
            <a href="index.php"><img src="https://picsum.photos/600/300?business" alt=""></a>
            <p>Example service</p>
            <img src="images/default_profile.png" alt="Profile Picture">
            <a id ="profile_name" href="index.php">Example name</a>
         </article>
      </section>
      <section id="services">
      <article class="service_card">
            <a href="index.php"><img src="https://picsum.photos/600/300?business" alt=""></a>
            <p>Example service</p>
            <img src="images/default_profile.png" alt="Profile Picture">
            <a id ="profile_name" href="index.php">Example name</a>
         </article>
         <article class="service_card">
            <a href="index.php"><img src="https://picsum.photos/600/300?business" alt=""></a>
            <p>Example service</p>
            <img src="images/default_profile.png" alt="Profile Picture">
            <a id ="profile_name" href="index.php">Example name</a>
         </article>
         <article class="service_card">
            <a href="index.php"><img src="https://picsum.photos/600/300?business" alt=""></a>
            <p>Example service</p>
            <img src="images/default_profile.png" alt="Profile Picture">
            <a id ="profile_name" href="index.php">Example name</a>
         </article>
      </section>
      <footer>
         <p>Name of the app</p>
         <p>name, date</p>
      </footer>
   </body>
</html>