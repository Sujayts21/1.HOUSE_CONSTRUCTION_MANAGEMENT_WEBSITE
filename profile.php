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
    <link rel="stylesheet" href="profile.css">
    <title>User Dashboard</title>
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
            font-size: 18px;
            text-align: left;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .table th, .table td {
            padding: 12px 15px;
        }

        .table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }

        .table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

        .thead {
            background-color: #009879;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
        }

        .tdetail {
            color: #333;
        }
        .progress{
        background-color: lightyellow;
        width:93%;
        margin:0 20px ;
        padding-top: 10px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px;
        border-radius: 20px;
      }
      .progress h2{
        text-align: center;
        margin-bottom: 20px;
      }
        h3{
        color: rgb(38, 54, 54);
        text-align: center;
        }
    </style>
</head>
<body>   
    <header>
        <div>           
            <a id="backhome" href="./profile.php">
            <img src="./assets/logo.jpg" alt="HomeCoMS Logo" class="logo">
            <span id="title">HomeCoMS</span></a>
        </div>
        <nav>
            <ul>
                <a href="logout.php" class="btn btn-warning">Logout</a>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="datafetch">
            <?php       
                $hostName = "localhost";
                $dbUser = "root";
                $dbPassword = "";
                $dbName = "homecoms";
                $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

                if (!$conn) {
                    die("Something went wrong;");
                }                
                $k=0;
                $budgettotal = 0;
                $materialstotal = 0;
                $salarytotal = 0;
                $sql = "SELECT homeowner_name, homeowner_contact,
                construction_address,num_storeys, extension,
                budget, deadline, engineer_name, engineer_contact,
                contractor_name,contractor_contact FROM users where id=$logged_user"; 
                $result = $conn->query($sql); 
                if ($result->num_rows > 0) { 
                while($row = $result->fetch_assoc()) { 
                    echo '<link rel="stylesheet" type="text/css" href="profile.css">';
                    echo "<div class='record'>";
                    echo '<h2>Basic Details</h2>';
                    echo "<span class='heading'>Homeowner Name: </span><span class='detail'>" . $row["homeowner_name"]. "</span><br>";
                    echo "<span class='heading'>Homeowner Contact Number: </span><span class='detail'>" . $row["homeowner_contact"]. "</span><br>";
                    echo "<span class='heading'>Construction Site Address: </span><span class='detail'>" . $row["construction_address"]. "</span><br>";
                    echo "<span class='heading'>Number of Storeys: </span><span class='detail'>" . $row["num_storeys"]. "</span><br>";
                    echo "<span class='heading'>Opted for Extension of Storeys in Future: </span><span class='detail'>";
                    if($row["extension"]==1){
                        echo "Yes</span><br>";
                    }else{                   
                        echo "No</span><br>";
                    }
                    echo "<span class='heading'>Expected maximum Budget: </span><span class='detail'>" . $row["budget"]. "</span><br>";
                    $k=$row['budget'];
                    echo "<span class='heading'>Expected Construction Deadline: </span><span class='detail'>" . $row["deadline"]. " months" ."</span><br>";
                    echo "<span class='heading'>Engineer's name: </span><span class='detail'>" . $row["engineer_name"]. "</span><br>";
                    echo "<span class='heading'>Engineer's Contact Number: </span><span class='detail'>" . $row["engineer_contact"]. "</span><br>";
                    echo "<span class='heading'>Contractor's name: </span><span class='detail'>" . $row["contractor_name"]. "</span><br>";
                    echo "<span class='heading'>Contractor's Contact Number: </span><span class='detail'>" . $row["contractor_contact"]. "</span><br>";
                    echo "</div>";
                } 
                } else { 
                echo "0 results"; 
                }
                $result = mysqli_query($conn, "SELECT * FROM budget where user_id=$logged_user");
                while ($row = $result->fetch_assoc()) {
                    $budgettotal += $row['amount'];
                }
                $result = mysqli_query($conn, "SELECT * FROM materials where user_id=$logged_user");
                while ($row = $result->fetch_assoc()) {
                    $materialstotal += $row['totalamt'];
                }
                $result = mysqli_query($conn, "SELECT * FROM salary where user_id=$logged_user");
                while ($row = $result->fetch_assoc()) {
                    $salarytotal += $row['totalsal'];
                }
                $currtot=$materialstotal+$budgettotal+$salarytotal;
                $remtot=$k-$currtot;
                $stmt = $conn->prepare("SELECT COUNT(*) as total_count FROM timeline WHERE user_id = ?");
                $stmt->bind_param("i", $logged_user);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $total_count = $row['total_count'];
                $stmt = $conn->prepare("SELECT COUNT(*) as completed_count FROM timeline WHERE user_id = ? AND current_status = 'completed'");
                $stmt->bind_param("i", $logged_user);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $completed_count = $row['completed_count'];
                $conn->close(); 
            ?>
        </div>
        <section class="progress">
            <?php
                if($total_count==0){
                    $progress="Timeline not yet prepared";
                }else{
                    $progress = ($completed_count/$total_count)*100;
                    $progress = round($progress,2)  . " %";
                }
            ?>
            <h2>Insight on Current Progress</h2>
            <table class="table">
                <thead>
                <tr>
                    <th class="thead">Budget Decided</th>
                    <th class="thead">Expenses</th>
                    <th class="thead">Workers' Salary Expenses</th>
                    <th class="thead">Materials Expenses</th>
                    <th class="thead">Current Total Expenditure</th>
                    <th class="thead">Remaining Budget</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="tdetail">Rs <?php echo $k; ?></td>
                    <td class="tdetail">Rs <?php echo $budgettotal; ?></td>
                    <td class="tdetail">Rs <?php echo $salarytotal; ?></td>
                    <td class="tdetail">Rs <?php echo $materialstotal; ?></td>
                    <td class="tdetail">Rs <?php echo $currtot; ?></td>
                    <td class="tdetail">Rs <?php echo $remtot; ?></td>
                </tr>   
                </tbody>            
            </table>
                <h3>Construction Progress: <?php echo $progress; ?></h3>
        </section>
        <div class="leaddash">
            <div class="usersdash">
                <h2>Homeowner</h2>
                <img src="./assets/homeownerimg.png">
                <p>1. View Timeline<br>
                   2. Manage Budget<br>
                   3. View Files<br>
                   4. Upload Files</p>
                <a class="leadusers" href="./homeowner/timelineview.php">My Dashboard➡️</a>
            </div>
            <div class="usersdash">
                <h2>Engineer</h2>
                <img src="./assets/engineerimg.png">
                <p>1. Manage Timeline<br>
                   2. View Timeline<br>
                   3. Manage Budget<br>
                   4. Upload Blueprint</p>
                <a class="leadusers" href="./engineer/managetimeline.php">My Dashboard➡️</a>
            </div>
            <div class="usersdash">
                <h2>Contractor</h2>
                <img src="./assets/contractorimg.png">
                <p>1. Manage Budget<br>
                   2. View Timeline<br>
                   3. Manage Workers<br>
                   4. Manage Materials</p>
                <a class="leadusers" href="./contractor/timelineview.php">My Dashboard➡️</a>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 HomeCoMS. All rights reserved.</p>
    </footer>
</body>
</html>