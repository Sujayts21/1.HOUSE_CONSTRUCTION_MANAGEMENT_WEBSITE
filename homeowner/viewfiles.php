<?php
session_start();
if (!isset($_SESSION["islogged"])) {
   header("Location: login.php");
}
$logged_user=$_SESSION['user']; //$var_value = $_SESSION['varname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="users.css">
    <title>Homeowner Dashboard</title>
    <style>
        .btn-danger{
            margin-right: 10%;
            margin-left: auto;
        }
        h3{
            margin-left: 15%;
        }
        .image{
            margin-left: 50%;
        }
        
        footer{
            position:sticky;
            bottom: 0;
            margin-top: 520px;
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
    <div class="container mt-5">
    <?php
    include_once("../database.php");
    $query = "SELECT * FROM uploadfiles where user_id=$logged_user";
    $result = mysqli_query($conn, $query);
    // Delete file
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
    
        $query = mysqli_query($conn, "DELETE FROM uploadfiles WHERE fid=$id");
        $_SESSION['message'] = "Log Deleted!";
        $_SESSION['msg_type'] = "danger";
    
        header("Location: viewfiles.php");
        exit();
    }
    
    echo "<a class='btn btn-info mb-4' href='uploadfiles.php'>Add New</a>"."<br>";
    if ($result->num_rows>0) {
        while($row = mysqli_fetch_array($result)){
            $name = $row["name"];
            $fileName = $row["filename"];
            $fileUrl = "../uploads/".$fileName;
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $docTypes = array("pdf", "doc", "docx");
            echo "<div class='profile mt-4'>";
            echo '<link rel="stylesheet" type="text/css" href="users.css">';
            if(in_array($ext, $docTypes)){       
                echo "<a href='$fileUrl'><img class='image' src='../uploads/docimg.png'/></a>";
            }else{
                echo "<a href='$fileUrl'><img class='image' src='../uploads/img.jpeg'/></a>";			
            }
            echo "<h3>$name</h3>";
            echo '<a href="viewfiles.php?delete=' . $row['fid'] . '" class="btn btn-danger">Delete</a>';
            echo "</div>";
        }
    }
    ?>
    </div>

    <footer>
        <p>&copy; 2024 HomeCoMS. All rights reserved.</p>
    </footer>
</body>
</html>