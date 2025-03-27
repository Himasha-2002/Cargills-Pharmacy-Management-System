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
        $sql_sales = "SELECT * FROM invoices WHERE inv_date BETWEEN '$start_date' AND '$end_date'";
        $sql_sales_total = "SELECT SUM(net_total) AS net_total FROM invoices WHERE inv_date BETWEEN '$start_date' AND '$end_date'";
    } else {
        $sql_sales_total = "SELECT SUM(net_total) AS net_total FROM invoices";
        $sql_sales = "SELECT * FROM invoices ORDER BY inv_number DESC";
    }
} else{
    $sql_sales = "SELECT * FROM invoices ORDER BY inv_number DESC";
    $sql_sales_total = "SELECT SUM(net_total) AS net_total FROM invoices";
}

$res_sales = mysqli_query($conn, $sql_sales);
$result_net_total = mysqli_query($conn, $sql_sales_total);
$row_net_total = mysqli_fetch_assoc($result_net_total);
$net_total = $row_net_total['net_total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sales report</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Sales-report.css">
</head>
<body>
    <!--sidebar-->
    <div class="sidebar">
        <div class="profile">
            <img src="Admin.jpg" alt="Admin">
            <h3>ADMIN</h3>
        </div>
        <div class="menu">
                <a href="..\dashboard\Dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a>
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
                    <a href="..\Medicine\Manage_Medicine.php">Manage Medicine</a>
                    <a href="..\Medicine\Manage_Medicine_Stock.php">Manage Medicine Stock</a>
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
        <!--sidebar Toggle button for smaller screen-->
        <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
    <div class="main-content">
        <!--header-->
        <div class="header">           
            <div>
                <h1><i class="fa-solid fa-cart-shopping"></i>Sales Report</h1>
                <p>Showing Sales Report</p>
            </div> 
            <!--Setting icon--> 
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
        <div class="filter">
            <div>
                <label for="start-date">Start Date:</label>
                <input type="date" name="start_date" id="start_date">
            </div>
            <div>
                <label for="end-date">End Date:</label>
                <input type="date" name="end_date" id="end_date">
            </div>
            <div>
                <button name="filter_date" class="btn btn-primary">Filter</button>
                <button class="btn btn-success">Reset</button>
            </div>
        </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Invoice Number</th>
                    <th>Customer Name</th>
                    <th>Sales Date</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while($row_sales = mysqli_fetch_assoc($res_sales)){
                ?>
                <tr>
                    <td><?php echo $row_sales['id']; ?></td>
                    <td><?php echo $row_sales['inv_number']; ?></td>
                    <td><?php echo $row_sales['customer_name']; ?></td>
                    <td><?php echo $row_sales['inv_date']; ?></td>
                    <td><?php echo $row_sales['net_total']; ?></td>
                </tr>
                <?php
                } ?>
            </tbody>
            <input type="text" style="display:none;" name="total_amount" value="<?php echo $net_total ?>" id="total_amount">
        </table>
        <div class="actions">
            <form action="../Medicine/Sales_Report_print.php" method="get" target="_blank">
                <input type="text" style="display: none;" name="start_date" value="<?php echo isset($start_date) ? $start_date : ''; ?>">
                <input type="text" style="display: none;" name="end_date" value="<?php echo isset($end_date) ? $end_date : ''; ?>">
                <button class="btn btn-primary" type="submit">PRINT</button>
            </form>
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
           // JavaScript to handle sidebar toggle on smaller screens
           function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
    </script>
    </body>
</html>