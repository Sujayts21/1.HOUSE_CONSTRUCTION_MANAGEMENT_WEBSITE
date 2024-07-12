<?php
session_start();
if (!isset($_SESSION["islogged"])) {
   header("Location: ../login.php");
}
$logged_user=$_SESSION['user']; //$var_value = $_SESSION['varname'];
include_once("../database.php");

$update = false;
$tid = 0;
$name = '';
$description = '';
$expected_days = '';
$current_status = 'to be done';

// Save new task
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $expected_days = $_POST['expected_days'];

    $stmt = $conn->prepare("INSERT INTO timeline (name, description, expected_days, current_status, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisi", $name, $description, $expected_days, $current_status, $logged_user);
    $stmt->execute();

    $_SESSION['message'] = "Task saved!";
    $_SESSION['msg_type'] = "primary";

    header("Location: managetimeline.php");
    exit();
}

// Delete task
if (isset($_GET['delete'])) {
    $tid = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM timeline WHERE tid = ? AND user_id = ?");
    $stmt->bind_param("ii", $tid, $logged_user);
    $stmt->execute();

    $_SESSION['message'] = "Task deleted!";
    $_SESSION['msg_type'] = "danger";

    header("Location: managetimeline.php");
    exit();
}

// Edit task
if (isset($_GET['edit'])) {
    $tid = $_GET['edit'];
    $update = true;

    $stmt = $conn->prepare("SELECT * FROM timeline WHERE tid = ? AND user_id = ?");
    $stmt->bind_param("ii", $tid, $logged_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $expected_days = $row['expected_days'];
        $current_status = $row['current_status'];
    }
}

// Update task
if (isset($_POST['update'])) {
    $tid = $_POST['tid'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $expected_days = $_POST['expected_days'];
    $current_status = $_POST['current_status'];

    $stmt = $conn->prepare("UPDATE timeline SET name = ?, description = ?, expected_days = ?, current_status = ? WHERE tid = ? AND user_id = ?");
    $stmt->bind_param("ssissi", $name, $description, $expected_days, $current_status, $tid, $logged_user);
    $stmt->execute();

    $_SESSION['message'] = "Task updated!";
    $_SESSION['msg_type'] = "success";
    header("Location: managetimeline.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="users.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Engineer Dashboard</title>
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
    background-color: lightgreen;
    color: #0b0b0b;
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
  footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px 0;
    margin-top: 300px;  
    position: sticky;
    bottom: 0; 
    left: 0; 
}

footer p {
    margin: 0;
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
            <a href="./managetimeline.php">Manage Timeline</a>           
            <a href="./timelineview.php">View Timeline</a>
            <a href="./managebudget.php">Manage Budget</a>
            <a href="./uploadfiles.php">Upload Files</a>
        </div>
        <nav>
            <ul>
                <a href="../logout.php" class="btn btn-warning">Logout</a>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3 class="text-center"><?= $update ? 'Edit Task' : 'Add Task' ?></h3>
                <form action="managetimeline.php" method="POST">
                    <input type="hidden" name="tid" value="<?= $tid; ?>">
                    <div class="form-group">
                        <label for="name">Task Name</label>
                        <input type="text" name="name" class="form-control" value="<?= $name; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" required><?= $description; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="expected_days">Expected Days</label>
                        <input type="number" name="expected_days" class="form-control" value="<?= $expected_days; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="current_status">Current Status</label>
                        <select name="current_status" class="form-control" required>
                            <option value="to be done" <?= $current_status == 'to be done' ? 'selected' : ''; ?>>To be done</option>
                            <option value="completed" <?= $current_status == 'completed' ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>
                    <button type="submit" name="<?= $update ? 'update' : 'save'; ?>" class="bttn btn-primary btn-block"><?= $update ? 'Update' : 'Save'; ?></button>
                </form>
            </div>
            <div class="col-md-8">
                <h3 class="text-center">Task List</h3>
                <?php if (isset($_SESSION['message'])): ?>
                <div class='alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show' role='alert'>
                    <strong><?php echo $_SESSION['message']; ?></strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
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
                            <th colspan="2">Action</th>
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
                                <td>
                                    <a href="managetimeline.php?edit=<?= $row['tid']; ?>" class="btn btn-success">Edit</a>
                                    <a href="managetimeline.php?delete=<?= $row['tid']; ?>" class="btn btn-danger">Delete</a>
                                </td>
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