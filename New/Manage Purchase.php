<?php 
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

//retireve all purchase details
$sql = "SELECT * FROM purchases ORDER BY inv_number DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Purchase</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/Manage-Purchase.css">
</head>
<body>
    <!--sidebar-->
    <div class="sidebar">
        <div class="profile">
            <br><img src="Admin.jpg" alt="Admin">
            <h3>ADMIN</h3>
        </div>
        <div class="menu">
            <a href="..\dashboard\Dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a><br>
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
        <!--header-->
        <div class="header">
           
            <div>
                <h1><i class="fa-solid fa-cart-shopping"></i>Manage Purchase</h1>
                <p>Manage Exisiting Purchase</p>
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
     
        <div class="search-section">
            <label for="voucher"><b>Search:</b></label>
            <input type="text" id="date" placeholder="By Date">
            <input type="text" id="supplier" placeholder="By Supplier Name">
            <input type="text" id="invoice" placeholder="By Invoice">
            <button onclick="window.location.href='Manage Purchase.php'" class="refresh">&#10227;</button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supplier Name</th>
                    <th>Invoice Number</th>
                    <th>Purchase Date</th>
                    <th>Payment Method</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
                
            </thead>
            <tbody>
                <?php 
                while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['supplier']; ?></td>
                    <td><?php echo $row['inv_number']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['payment_type']; ?></td>
                    <td><?php echo $row['grand_total']; ?></td>
                    <td>
                        <button onclick="location.href='update_purchase.php?id=<?php echo $row['id']; ?>'"
                            class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                    </td>
                </tr>
                <?php
                } ?>
            </tbody>
        </table>
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

        //search items
        document.addEventListener("DOMContentLoaded", function () {
            const dateInput = document.getElementById("date");
            const supplierInput = document.getElementById("supplier");
            const invoiceInput = document.getElementById("invoice");
            const tableRows = document.querySelectorAll("tbody tr");

            function filterTable() {
                let dateValue = dateInput.value.toLowerCase();
                let supplierValue = supplierInput.value.toLowerCase();
                let invoiceValue = invoiceInput.value.toLowerCase();

                tableRows.forEach(row => {
                    let dateText = row.children[3].textContent.toLowerCase();
                    let supplierText = row.children[1].textContent.toLowerCase();
                    let invoiceText = row.children[2].textContent.toLowerCase();

                    if(dateText.includes(dateValue) && supplierText.includes(supplierValue) && invoiceText.includes(invoiceValue)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            dateInput.addEventListener("input", filterTable);
            supplierInput.addEventListener("input", filterTable);
            invoiceInput.addEventListener("input", filterTable);
        });
    </script>
</body>
</html>

        