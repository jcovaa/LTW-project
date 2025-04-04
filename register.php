<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      <link rel="stylesheet" href="login.css">
      <title>Join us</title>
   </head>
   <body>
      <form action="">
         <h1>Create an account</h1>
         <div class="input_box">
            <input type="text" placeholder="username" required>
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
            <p>Already have an account?<a href="login.php">Login</a></p>
         </div>
      </form>
   </body>
</html>