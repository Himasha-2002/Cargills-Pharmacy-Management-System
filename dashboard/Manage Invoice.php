<?php
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

//retrieve all invoice details
$sql = "SELECT * FROM invoices ORDER BY inv_number DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Invoice</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/Manage-Invoice.css">
</head>

<body>
    <div class="sidebar">
        <div class="profile">
            <img src="Admin.jpg" alt="Admin">
            <h3>ADMIN</h3>
        </div>
        <div class="menu">
            <a href="..\dashboard\Dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-file-invoice"></i> Invoice<span class="toggle">
                        <</span></a>
                <div class="dropdown-content">
                    <a href="..\Cargils\New Invoice.php">New Invoice</a>
                    <a href="..\dashboard\Manage Invoice.php">Manage Invoice</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-users"></i> Customer<span class="toggle">
                        <</span></a>
                <div class="dropdown-content">
                    <a href="..\New\Add Customer.php">Add Customer</a>
                    <a href="..\Naduni\Manage Customer.php">Manage Customer</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-capsules"></i> Medicine<span class="toggle">
                        <</span></a>
                <div class="dropdown-content">
                    <a href="..\Medicine\Add_Medicine.php">Add Medicine</a>
                    <a href="..\Medicine\Manage_medicine.php">Manage Medicine</a>
                    <a href="..\Medicine\Manage_medicine_Stock.php">Manage Medicine Stock</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fas fa-truck"></i> Supplier<span class="toggle">
                        <</span></a>
                <div class="dropdown-content">
                    <a href="..\Cargils\Add Supplier.php">Add Supplier</a>
                    <a href="..\Cargils\Manage Supplier.php">Manage Supplier</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-cart-shopping"></i> Purchase<span class="toggle">
                        <</span></a>
                <div class="dropdown-content">
                    <a href="..\New\Add Purchase.php">Add Purchase</a>
                    <a href="..\New\Manage Purchase.php">Manage Purchase</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fas fa-chart-bar"></i> Report<span class="toggle">
                        <</span></a>
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
        <div class="header">
            <div>
                <h1><i class="fa-solid fa-cart-shopping"></i>Manage Invoice</h1>
                <p>Manage Existing Invoice</p>
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
        <!--search section-->
        <div class="search-section">
            <label for="voucher"><b>Search:</b></label>
            <input type="text" id="invoice" placeholder="Invoice Number">
            <input type="text" id="customer" placeholder="By Customer Name">
            <input type="text" id="date" placeholder="By Invoice Date">
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Invoice Number</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Total Discount</th>
                    <th>Net Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['inv_number']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['inv_date']; ?></td>
                        <td><?php echo $row['total_amount']; ?></td>
                        <td><?php echo $row['total_discount']; ?></td>
                        <td><?php echo $row['net_total']; ?></td>
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
        // JavaScript to handle sidebar toggle on smaller screens
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }

        //search filter
        document.addEventListener("DOMContentLoaded", function () {
            const invoiceInput = document.getElementById("invoice");
            const customerInput = document.getElementById("customer");
            const dateInput = document.getElementById("date");
            const tableRows = document.querySelectorAll("tbody tr");

            function filterTable() {
                let invoiceValue = invoiceInput.value.toLowerCase();
                let customerValue = customerInput.value.toLowerCase();
                let dateValue = dateInput.value.toLowerCase();

                tableRows.forEach(row => {
                    let invoiceText = row.children[1].textContent.toLowerCase();
                    let customerText = row.children[2].textContent.toLowerCase();
                    let dateText = row.children[3].textContent.toLowerCase();

                    if (
                        invoiceText.includes(invoiceValue) &&
                        customerText.includes(customerValue) &&
                        dateText.includes(dateValue)
                    ) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            // Attach event listeners to input fields
            invoiceInput.addEventListener("input", filterTable);
            customerInput.addEventListener("input", filterTable);
            dateInput.addEventListener("input", filterTable);
        })
    </script>
</body>

</html>