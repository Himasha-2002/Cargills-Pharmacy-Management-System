<?php 
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

$start_date = "";
$end_date = "";

//filter or default sales details
if(isset($_POST['filter_date'])){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if(!empty($start_date) && !empty($end_date)){
        $sql_purchases = "SELECT * FROM purchases WHERE date BETWEEN '$start_date' AND '$end_date'";
        $sql_purchases_total = "SELECT SUM(grand_total) AS grand_total FROM purchases WHERE date BETWEEN '$start_date' AND '$end_date'";
    } else {
        $sql_purchases_total = "SELECT SUM(grand_total) AS grand_total FROM purchases";
        $sql_purchases = "SELECT * FROM purchases ORDER BY inv_number DESC";
    }
} else{
    $sql_purchases = "SELECT * FROM purchases ORDER BY inv_number DESC";
    $sql_purchases_total = "SELECT SUM(grand_total) AS grand_total FROM purchases";
}

$res_purchases = mysqli_query($conn, $sql_purchases);
$result_grand_total = mysqli_query($conn, $sql_purchases_total);
$row_grand_total = mysqli_fetch_assoc($result_grand_total);
$grand_total = $row_grand_total['grand_total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Report</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Purchase-Report.css">
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <br><img src="Admin.jpg" alt="Admin">
            <h3>ADMIN</h3>
        </div>
        <div class="menu">
            <a href="..\dashboard\Dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a> <br>
        <div class="dropdown">
            <a href="#"><i class="fa-solid fa-file-invoice"></i> Invoice<span class="toggle"><</span></a>
            <div class="dropdown-content">
                <a href="..\Cargils\New Invoice.php">New Invoice</a>
                <a href="..\dashboard\Manage Invoice.php">Manage Invoice</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#"><i class="fa-solid fa-users"></i> Customer<span class="toggle"><</span></a>
            <div class="dropdown-content">
                <a href="..\New\Add Customer.php">Add Customer</a>
                <a href="..\Naduni\Manage Customer.php">Manage Customer</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#"><i class="fa-solid fa-capsules"></i> Medicine<span class="toggle"><</span></a>
            <div class="dropdown-content">
                <a href="..\Medicine\Add_Medicine.php">Add Medicine</a>
                <a href="..\Medicine\Manage_medicine.php">Manage Medicine</a>
                <a href="..\Medicine\Manage_medicine_Stock.php">Manage Medicine Stock</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#"><i class="fas fa-truck"></i> Supplier<span class="toggle"><</span></a>
            <div class="dropdown-content">
                <a href="..\Cargils\Add Supplier.php">Add Supplier</a>
                <a href="..\Cargils\Manage Supplier.php">Manage Supplier</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#"><i class="fa-solid fa-cart-shopping"></i> Purchase<span class="toggle"><</span></a>
            <div class="dropdown-content">
                <a href="..\New\Add Purchase.php">Add Purchase</a>
                <a href="..\New\Manage Purchase.php">Manage Purchase</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#"><i class="fas fa-chart-bar"></i> Report<span class="toggle"><</span></a>
            <div class="dropdown-content">
                <a href="..\dashboard\Sales report.php">Sales Report</a>
                <a href="..\New\Purchase Report.php">Purchase Report</a>
            </div>
        </div>  
    </div>
    </div>
    <div class="main-content">
        <div class="header">
           
            <div>
                <h1><i class="fa-solid fa-cart-shopping"></i>Purchase Report</h1>
                <p>Showing Purchase Report</p>
            </div>
        
            <div class="settings-dropdown">
                <a href="#"><i class="fas fa-cog settings-icon"></i></a>
                <div class="settings-menu">
                    <a href="..\Naduni\Profile.php"><i class="fas fa-user"></i>My Profile</a>
                    <a href="..\Cargils\Password.php"><i class="fas fa-key"></i>Change Password</a>
                    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                </div>
            </div>
        </div>
        <form action="" method="post">
        <div class="filters">
            <div>
                <label for="start-date"><b>Start Date:</b></label>
                <input type="date" name="start_date" id="start-date">
            </div>
            <div>
                <label for="end-date"><b>End Date:</b></label>
                <input type="date" name="end_date" id="end-date">
            </div>
            <div>
                <button name="filter_date" name="filter_date" class="btn btn-primary">Filter</button>
                <button class="btn btn-success">Reset</button>
            </div>
        </div>
        </form>
        <br><table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Invoice Number</th>
                    <th>Supplier Name</th>
                    <th>Purchase Date</th>
                    <th>Payment Type</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while($row_purchases = mysqli_fetch_assoc($res_purchases)){
                ?>
                <tr>
                    <td><?php echo $row_purchases['id']; ?></td>
                    <td><?php echo $row_purchases['inv_number']; ?></td>
                    <td><?php echo $row_purchases['supplier']; ?></td>
                    <td><?php echo $row_purchases['date']; ?></td>
                    <td><?php echo $row_purchases['payment_type']; ?></td>
                    <td><?php echo $row_purchases['grand_total']; ?></td>
                </tr>
                <?php
                } ?>
            </tbody>
        </table>
        <br><br>
        <div class="print-btn">
            <form action="../Naduni/purchersReport.php" method="get" target="_blank">
                <input type="text" style="display: none;" name="start_date" value="<?php echo isset($start_date) ? $start_date : ''; ?>">
                <input type="text" style="display: none;" name="end_date" value="<?php echo isset($end_date) ? $end_date : ''; ?>">
                <button class="btn btn-primary" type="submit">PRINT</button>
            </form>
        </div>
    </div>
    <script>
        // JavaScript to handle dropdown functionality
        const dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.toggle');
            const content = dropdown.querySelector('.dropdown-content');

            toggle.addEventListener('click', () => {
                const isVisible = content.style.display === 'flex';
                content.style.display = isVisible ? 'none' : 'flex';
                toggle.textContent = isVisible ? '<' : 'v'; 
            });
        });

        // JavaScript to handle settings dropdown functionality
        
        const settingsIcon = document.querySelector('.settings-icon');
            const settingsMenu = document.querySelector('.settings-menu');

            settingsIcon.addEventListener('click', (e) => {
            e.preventDefault();
            const isVisible = settingsMenu.style.display === 'block';
            settingsMenu.style.display = isVisible ? 'none' : 'block';
            });

            document.addEventListener('click', (e) => {
            if (!e.target.closest('.settings-dropdown')) {
            settingsMenu.style.display = 'none';
             }
            });
    </script>
</body>
</html>
