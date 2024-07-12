<?php
session_start();
if (!isset($_SESSION["islogged"])) {
    header("Location: login.php");
    exit();
}
$logged_user = $_SESSION['user']; // $var_value = $_SESSION['varname'];

include_once("../database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="users.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Homeowner Dashboard</title>
    <style>
        body {
            background-color: lightgrey;
        }
        .bttn {
            display: block;
            padding: 10px;
            background-color: #ebaf0a;
            color: #0b0b0b;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .bttn:hover {
            background-color: darkseagreen;
        }
        footer {
            position: fixed;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <a id="backhome" href="../profile.php">
                <img src="../assets/logo.jpg" alt="HomeCoMS Logo" class="logo">
                <span id="title">HomeCoMS</span>
            </a>
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
        <h2>Upload Files</h2>
        <?php
        if (isset($_SESSION['message'])): ?>
        <div class="<?php echo $_SESSION['msg_type']; ?>">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            unset($_SESSION['msg_type']);
            ?>
        </div>
        <?php endif; ?>
        <form action="uploadfiles.php" method="post" enctype="multipart/form-data">
            <input class="form-control mt-4" type="text" name="fullname" id="" placeholder="Enter File Name:" required>
            <input class="form-control mt-4" type="file" name="file" id="" required>
            <input class="bttn btn-primary mt-4" type="submit" value="Upload" name="submit">
        </form>
    </div>
    <footer>
        <p>&copy; 2024 HomeCoMS. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php
if (isset($_POST["submit"])) {
    $fullName = $_POST["fullname"];
    $fileName = $_FILES["file"]["name"];
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowedTypes = array("jpg", "jpeg", "png", "gif", "pdf", "doc", "docx");
    $tempName = $_FILES["file"]["tmp_name"];
    $targetPath = "../uploads/".$fileName;

    if (in_array($ext, $allowedTypes)) {
        if (move_uploaded_file($tempName, $targetPath)) {
            $stmt = $conn->prepare("INSERT INTO uploadfiles (name, filename, user_id) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $fullName, $fileName, $logged_user);

            if ($stmt->execute()) {
                $_SESSION['message'] = "File uploaded and saved in database successfully!";
                $_SESSION['msg_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to save file information in the database.";
                $_SESSION['msg_type'] = "danger";
            }

            $stmt->close();
        } else {
            $_SESSION['message'] = "File is not uploaded.";
            $_SESSION['msg_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Your files are not allowed.";
        $_SESSION['msg_type'] = "danger";
    }
    header("Location: uploadfiles.php");
    exit();
}
?>
