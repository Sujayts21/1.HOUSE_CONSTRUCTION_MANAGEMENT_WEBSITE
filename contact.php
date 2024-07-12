<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeCoMS - Home</title>
    <link rel="stylesheet" href="./menu.css">
    <style>
        footer{
            position:fixed;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <a id="backhome" href="./index.php">
            <img src="./assets/logo.jpg" alt="HomeCoMS Logo" class="logo">
            <span id="title">HomeCoMS</span></a>
        </div>
        <nav>
            <ul>
                <li><a href="./registration.php">Register</a></li>
                <li><a href="./login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
      <h2>Contact Us</h2>
      <?php
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $name = $_POST["fullname"];
        $email = $_POST["email"];   
        $subject = $_POST["subject"];
        $message = $_POST["message"];
        $to="charansai0745@gmail.com";
        $headers= "From: $email";
        if(mail($to,$subject,$message,$headers)){
            echo '<link rel="stylesheet" type="text/css" href="menu.css">';
            echo "<div class='alert alert-success'>Email sent successfully.</div>";
        }else{
            echo '<link rel="stylesheet" type="text/css" href="menu.css">';
            echo "<div class='alert alert-danger'>Email could not be sent.</div>";
        }
    }
    ?>
      <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
          <div class="form-group">
              <label for="fullname">Name:</label>
              <input type="text" id="fullname" name="fullname" required>
          </div>
          <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
              <label for="subject">Subject:</label>
              <input type="text" id="subject" name="subject" required>
          </div>
          <div class="form-group">
              <label for="message">Message:</label>
              <textarea id="message" name="message" required></textarea>
          </div>
          <button type="submit">Submit</button>
      </form>
  </div>
    <footer>
        <p>&copy; 2024 HomeCoMS. All rights reserved.</p>
    </footer>
</body>
</html>
