<?php 
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

$date = date("Y-m");

//retrieve all customers details
$sql_customers = "SELECT COUNT(*) AS customer_count FROM customers";
$result_customers = mysqli_query($conn, $sql_customers);
$row_customers = mysqli_fetch_assoc($result_customers);
$customer_count = $row_customers['customer_count'];

//retrieve all supplier details
$sql_supplier = "SELECT COUNT(*) AS supplier_count FROM supplier";
$result_supplier = mysqli_query($conn, $sql_supplier);
$row_supplier = mysqli_fetch_assoc($result_supplier);
$supplier_count = $row_supplier['supplier_count'];

//retrieve all medicine details
$sql_medicine = "SELECT COUNT(*) AS medicine_count FROM medicine";
$result_medicine = mysqli_query($conn, $sql_medicine);
$row_medicine = mysqli_fetch_assoc($result_medicine);
$medicine_count = $row_medicine['medicine_count'];

//retrieve all medicine_stock details
$sql_medicine_out = "SELECT COUNT(*) AS medicine_count_out FROM medicine_stock WHERE quantity = 0";
$result_medicine_out = mysqli_query($conn, $sql_medicine_out);
$row_medicine_out = mysqli_fetch_assoc($result_medicine_out);
$medicine_count_out = $row_medicine_out['medicine_count_out'];

//retrieve all medicine_stock details
$sql_medicine_expire = "SELECT COUNT(*) AS medicine_count_expire FROM medicine_stock WHERE expire_date < $date";
$result_medicine_expire = mysqli_query($conn, $sql_medicine_expire);
$row_medicine_expire = mysqli_fetch_assoc($result_medicine_expire);
$medicine_count_expire = $row_medicine_expire['medicine_count_expire'];

//retrieve all invoices details
$sql_invoices = "SELECT COUNT(*) AS invoices_count FROM invoices";
$result_invoices = mysqli_query($conn, $sql_invoices);
$row_invoices = mysqli_fetch_assoc($result_invoices);
$invoices_count = $row_invoices['invoices_count'];

//retrieve all sales details
$sql_sales = "SELECT SUM(net_total) AS net_total FROM invoices";
$result_net_total = mysqli_query($conn, $sql_sales);
$row_net_total = mysqli_fetch_assoc($result_net_total);
$net_total = $row_net_total['net_total'];

//retrieve all purchases details
$sql_purchases = "SELECT SUM(grand_total) AS grand_total FROM purchases";
$result_grand_total = mysqli_query($conn, $sql_purchases);
$row_grand_total = mysqli_fetch_assoc($result_grand_total);
$grand_total = $row_grand_total['grand_total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <br><img src="Admin.jpg" alt="Admin">
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
                    <a href="..\Medicine\Manage_medicine_Stock.php">Manage Medicine</a>
                    <a href="..\Medicine\Manage_medicine.php">Manage Medicine Stock</a>
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
                <h1><i class="fa-solid fa-cart-shopping"></i>Dashboard</h1>           
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
        <div class="overview3">
        <section class="overview">
            <div class="card"><b>Total Customer: <br><span><?php echo $customer_count ?></span></b></div>
            <div class="card"><b>Total Supplier: <br><span><?php echo $supplier_count ?></span></b></div>
            <div class="card"><b>Total Medicine: <br><span><?php echo $medicine_count ?></span></b></div>
            <div class="card"><b>Out Of Stock: <br><span><?php echo $medicine_count_out ?></span></b></div>
            <div class="card"><b>Expired: <br><span><?php echo $medicine_count_expire ?></span></b></div>
            <div class="card"><b>Total Invoice: <br><span><?php echo $invoices_count ?></span></b></div>
            
          </section>
          <div class="overview2">
            <div class="card"><br>
                <h3><b>Today's Report</b></h3><br><br>
                <p><b>Total Sales: Rs.<?php echo $net_total ?></b></p><br><br>
                <p><b>Total Purchase: Rs.<?php echo $grand_total ?></b></p><br>
              </div>
          </div>
        </div>
        <hr class="styled-hr"></br></br>
          <section class="actions">
            <a href="..\Cargils\New Invoice.php" class="action-link">
            <button class="action-btn"><i class="fa-solid fa-file-invoice"></i><br><br><b>Create New Invoice</b></button></a>
            <a href="..\New\Add Customer.php" class="action-link">
            <button class="action-btn"><i class="fa-solid fa-users"></i><br><br></b><b>Add New Customer</b></button></a>
            <a href="..\Medicine\Add_Medicine.php" class="action-link">
            <button class="action-btn"><i class="fa-solid fa-capsules"></i><br><br><b>Add New Medicine</b></button></a>
            <a href="..\Cargils\Add Supplier.php" class="action-link">
            <button class="action-btn"><i class="fas fa-truck"></i><br><br><b>Add New Supplier</b></button></a>
            <a href="..\New\Add Purchase.php" class="action-link">
            <button class="action-btn"><i class="fa-solid fa-cart-shopping"></i><br><br><b>Add New Purchase</b></button></a>
            <a href="..\dashboard\Sales report.php" class="action-link">
            <button class="action-btn"><i class="fas fa-chart-bar"></i><br><br><b>Sales Report</b></button></a>
            <a href="..\New\Purchase Report.php" class="action-link">
            <button class="action-btn"><i class="fas fa-chart-bar"></i><br><br><b>Purchase Report</b></button></a>
        </section>
        </main>
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
                toggle.textContent = isVisible ? '<' : 'v'; // Toggle symbol
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