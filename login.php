<?php
session_start();
if (isset($_SESSION["islogged"])) {
   header("Location: profile.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="menu.css">
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
                <li><a href="registration.php">Register</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
    <h2>Login</h2>
        <?php
        if (isset($_POST["login"])) {
           $username = $_POST["username"];
           $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);
            //print_r($result);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            //print_r($user);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    session_start();
                    $_SESSION["islogged"] = "yes";
                    $_SESSION["user"] = $user['id'];
                    //$_SESSION['varname'] = $var_value;
                    header("Location: profile.php");
                    die();
                }else{
                    echo '<link rel="stylesheet" type="text/css" href="menu.css">';
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            }else{
                echo '<link rel="stylesheet" type="text/css" href="menu.css">';
                echo "<div class='alert alert-danger'>Username does not match</div>";
            }
        }
        ?>
      <form action="login.php" method="post">
        <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" placeholder="Enter Username:" name="username">
        </div>
        <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" placeholder="Enter Password:" name="password">
        </div>
        <div class="form-btn">
            <input type="submit" value="Login" name="login" class="btn btn-primary">
        </div>
      </form>
     <div><p>Not registered yet <a href="registration.php">Register Here</a></p></div>
    </div>       
    <footer>
        <p>&copy; 2024 HomeCoMS. All rights reserved.</p>
    </footer>
</body>
</html>