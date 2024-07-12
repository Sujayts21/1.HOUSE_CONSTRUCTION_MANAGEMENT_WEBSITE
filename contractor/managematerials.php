<?php
session_start();
if (!isset($_SESSION["islogged"])) {
   header("Location: ../login.php");
}
$logged_user=$_SESSION['user']; //$var_value = $_SESSION['varname'];

include_once("../database.php");

$total = 0;
$update = false;
$id = 0;
$name = '';
$amount = '';
$quantity = '';
$totalamt='';

// Save new expense
if (isset($_POST['save'])) {
    $material = $_POST['material'];
    $amount = $_POST['amount'];
    $quantity = $_POST['quantity'];
    $totalamt =$amount*$quantity;

    $query = mysqli_query($conn, "INSERT INTO materials (name, amount, quantity,totalamt,user_id) VALUES ('$material', '$amount', '$quantity', '$totalamt', '$logged_user')");

    $_SESSION['message'] = "Log saved!";
    $_SESSION['msg_type'] = "primary";

    header("Location: managematerials.php");
    exit();
}

// Calculate total
$result = mysqli_query($conn, "SELECT * FROM materials where user_id=$logged_user");
while ($row = $result->fetch_assoc()) {
    $total += $row['totalamt'];
}

// Delete expense
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM materials WHERE mid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['message'] = "Log Deleted!";
    $_SESSION['msg_type'] = "danger";

    header("Location: managematerials.php");
    exit();
}

// Edit expense
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM materials WHERE mid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $amount = $row['amount'];
        $quantity = $row['quantity'];
        $totalamt = $row['totalamt'];
    }
}


// Update expense
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $material = $_POST['material'];
    $amount = $_POST['amount'];
    $quantity = $_POST['quantity'];
    $totalamt = $amount * $quantity; // Calculate total amount

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE materials SET name=?, amount=?, quantity=?, totalamt=? WHERE mid=?");
    $stmt->bind_param("ssisi", $material, $amount, $quantity, $totalamt, $id);
    $stmt->execute();

    $_SESSION['message'] = "Log Updated!";
    $_SESSION['msg_type'] = "success";
    header("Location: managematerials.php");
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
    <title>Contractor Dashboard</title>
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
  .btttn {
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
    
    .btttn:hover {
        background-color: lightgreen;
        color: #0b0b0b;
    }
  .navigator{
    display:flex;
    justify-content: space-between;
    margin-left: 0;
  }
  .col-md-8{
    padding-left: 20px;
    border-left: solid black 1px;
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
    margin-top: 20px;  
    position: fixed;
    bottom: 0; 
    left: 0; 
    z-index: 10;
    width: 100%;
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
            <a href="./timelineview.php">View Timeline</a>
            <a href="./managebudget.php">Manage Budget</a>
            <a href="./manageworkers.php">Manage Workers</a>
            <a href="./managematerials.php">Manage Materials</a>
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
                <h3 class="text-center"><?= $update ? 'Edit Material Expense' : 'Add Material  Expense' ?></h3>
            <hr>
            <form action="managematerials.php" method="POST">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                <div class="form-group">
                    <label for="budgetTitle">Material Purchased</label>
                    <input type="text" name="material" class="form-control" id="materialTitle" placeholder="Enter Material Name" value="<?= $name; ?>" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Enter Quantity" value="<?= $quantity; ?>" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="text" name="amount" class="form-control" id="amount" placeholder="Enter Amount in Rupees" value="<?= $amount; ?>"  required autocomplete="off">
                </div>
                    <button type="submit" name="<?= $update ? 'update' : 'save'; ?>" class="bttn btn-primary btn-block"><?= $update ? 'Update' : 'Save'; ?></button>
            </form>
        </div>
        <div class="col-md-8">
            <h2 class="text-center">Total Material Expenses : Rs <?php echo $total; ?></h2>
            <hr><br>

            <?php if (isset($_SESSION['message'])): ?>
                <div class='alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show' role='alert'>
                    <strong><?php echo $_SESSION['message']; ?></strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <h2>Material Expenses List</h2>

            <?php $result = mysqli_query($conn, "SELECT * FROM materials where user_id=$logged_user"); ?>
            <div class="row justify-content-center">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Material Name</th>
                        <th>Amount</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                        <th colspan="2">Action</th>
                    </tr>
                    </thead>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td>Rs <?php echo $row['amount']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td>Rs <?php echo $row['totalamt']; ?></td>
                            <td>
                                <a href="managematerials.php?edit=<?php echo $row['mid']; ?>" class="btn btn-success">Update</a>
                                <a href="managematerials.php?delete=<?php echo $row['mid']; ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
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