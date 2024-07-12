<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="menu.css">
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
                <li><a href="login.php">Login</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
    <h2>Register</h2>
        <?php
            if(isset($_POST["submit"])){
                $homeowner_name = $_POST["homeowner_name"];
                $homeowner_contact = $_POST["homeowner_contact"];
                $construction_address = $_POST["construction_address"];
                $num_storeys = $_POST["num_storeys"];
                $extension = $_POST["extension"];
                $budget = $_POST["budget"];
                $deadline = $_POST["deadline"];
                $engineer_name = $_POST["engineer_name"];
                $engineer_contact = $_POST["engineer_contact"];
                $contractor_name = $_POST["contractor_name"];
                $contractor_contact = $_POST["contractor_contact"];
                $username = $_POST["username"];
                $password = $_POST["password"];
                $repeat_password = $_POST["repeat_password"];
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $errors = array();
                if(strlen($homeowner_contact)!=10 OR strlen($engineer_contact)!=10 OR strlen($contractor_contact)!=10){
                    array_push($errors,"Enter the valid contact numbers");
                }
                if(strlen($password)<8){
                    array_push($errors,"Password must be atleast 8 characters long");
                }
                if($password!=$repeat_password){
                    array_push($errors,"Password does not match");
                }
                require_once "database.php";
                $sql = "SELECT * FROM users WHERE username = '$username'";
                $result = mysqli_query($conn, $sql);
                $rowCount = mysqli_num_rows($result);
                if ($rowCount>0) {
                    array_push($errors,"Username already exists!");
                }
                if (count($errors)>0) {
                    foreach ($errors as  $error) {
                        echo '<link rel="stylesheet" type="text/css" href="menu.css">';
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                }else{
                    $sql = "INSERT INTO users (username,password,homeowner_name,homeowner_contact,construction_address,num_storeys,budget,deadline,	engineer_name,engineer_contact,contractor_name,contractor_contact,extension) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn); //Initializes a statement and returns an object for use with mysqli_stmt_prepare
                    $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                        if ($prepareStmt) {
                            mysqli_stmt_bind_param($stmt,"sssisidisisii",$username,$passwordHash,$homeowner_name,$homeowner_contact,$construction_address,$num_storeys,$budget,$deadline,$engineer_name,$engineer_contact,$contractor_name,$contractor_contact,$extension);
                            mysqli_stmt_execute($stmt);
                            echo '<link rel="stylesheet" type="text/css" href="menu.css">';
                            echo "<div class='alert alert-success'>You are registered successfully.</div>";
                        }else{
                            die("Something went wrong");
                        }
                    }
            }
        ?>
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
            <div class="form-group">
                <label for="homeowner_name">Homeowner Name:</label>
                <input type="text" class="form-control" name="homeowner_name" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <label for="homeowner_contact">Homeowner Contact Number:</label>
                <input type="number" class="form-control" name="homeowner_contact" placeholder="Phone Number" required>
            </div>
            <div class="form-group">
                <label for="construction_address">Construction Site Address:</label>
                <input type="text" class="form-control" name="construction_address" placeholder="Site Address" required>
            </div>
            <div class="form-group">
                <label for="num_storeys">Number of Storeys:</label>
                <input type="number" class="form-control" name="num_storeys" placeholder="In digits" required>
            </div>
            <div class="form-group">
                <label for="extension">Opt for Extension of  Storeys in Future:</label>
                <select class="form-control" name="extension">
                    <option value="1" selected>Yes</option>
                    <option value="0" selected>No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="budget">Expected maximum Budget:</label>
                <input type="number" class="form-control" name="budget" placeholder="In digits" required>
            </div>
            <div class="form-group">
                <label for="deadline">Expected Construction Deadline:</label>
                <input type="number" class="form-control" name="deadline" placeholder="In months" required>
            </div>
            <div class="form-group">
                <label for="engineer_name">Engineer's name:</label>
                <input type="text" class="form-control" name="engineer_name" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <label for="engineer_contact">Engineer's Contact Number:</label>
                <input type="number" class="form-control" name="engineer_contact" placeholder="In digits" required>
            </div>
            <div class="form-group">
                <label for="contractor_name">Contractor's name:</label>
                <input type="text" class="form-control" name="contractor_name" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <label for="contractor_contact">Contractor's Contact Number:</label>
                <input type="number" class="form-control" name="contractor_contact" placeholder="In digits" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="password" required>
            </div>
            <div class="form-group">
                <label for="repeat_password">Repeat Password:</label>
                <input type="password" class="form-control" name="repeat_password" placeholder="password" required>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
    </div>
    
    <footer>
        <p>&copy; 2024 HomeCoMS. All rights reserved.</p>
    </footer>
</body>
</html>