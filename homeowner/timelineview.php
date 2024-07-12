<?php
session_start();
if (!isset($_SESSION["islogged"])) {
   header("Location: ../login.php");
}
$logged_user=$_SESSION['user']; //$var_value = $_SESSION['varname'];
include_once("../database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="users.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Homeowner Dashboard</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: lightgray;
  }
  header {
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;  
    position: sticky;
    top:0; 
    left: 0; 
    z-index: 10;
  }
  #backhome{
    text-decoration: none;
    color: white;
  }
  .logo {
    float: inline-start;
    width: 30px;
    height: auto;
  }
  #title{
    margin-left: 10px;
    font-size: 30px;
  
  }
  
  .col-md-8{
    padding-left: 20px;
    border-left: solid black 1px;
  }
  nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
  }
  
  nav ul li {
    display: inline;
    margin-left: 20px;
  }
  
  nav ul li a {
    color: #fff;
    text-decoration: none;
  }
  .bttn {
    display: block;
    padding: 5px;
    background-color: #ebaf0a;
    color: #0b0b0b;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .bttn:hover {
    background-color: #f80404;
  }
  .navigator{
    display:flex;
    justify-content: space-between;
    margin-left: 0;
  }
  .navigator a{
    text-decoration: none;
    color: #fff;
    margin-right: 20px;
    padding: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  .navigator a:hover {
    background-color: grey;
  }

   footer{
    position: sticky;
    bottom: 0; 
    margin-top: 450px;  
   }

</style>
</head>
<body>   
    <header>
        <div>           
            <a id="backhome" href="../profile.php">
            <img src="../assets/logo.jpg" alt="HomeCoMS Logo" class="logo">
            <span id="title">HomeCoMS</span></a>
        </div>
        <div class="navigator">           
            <a href="./timelineview.php">View Timeline</a>
            <a href="./managebudget.php">Manage Budget</a>
            <a href="./viewfiles.php">View Files</a>
            <a href="./uploadfiles.php">Upload Files</a>
        </div>
        <nav>
            <ul>
                <a href="../logout.php" class="btn btn-warning">Logout</a>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2 class="text-center">View Timeline</h2>
        <div class="row">
            <div class="col-md-12">
                <?php
                $result = $conn->query("SELECT * FROM timeline WHERE user_id = $logged_user");
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Task Name</th>
                            <th>Description</th>
                            <th>Expected Days</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php $i=$i+1; echo $i; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['description']; ?></td>
                                <td><?= $row['expected_days']; ?></td>
                                <td><?= $row['current_status']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 HomeCoMS. All rights reserved.</p>
    </footer>
<script src="js/jquery-3.2.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>