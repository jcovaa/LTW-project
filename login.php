<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      <link rel="stylesheet" href="login.css">
      <title>Login</title>
   </head>
   <body>
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
   </body>
</html>