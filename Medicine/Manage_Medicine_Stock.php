<?php
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

//retrieve all medicine_stock details
$sql = "SELECT medicine_stock.*, medicine.generic_name, medicine.supplier FROM medicine_stock LEFT JOIN medicine ON medicine_stock.medicine_name = medicine.medicine_name";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Medicine Stock</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/Manage_Medicine_Stock.css">
</head>

<body>
    <div class="sidebar">
        <div class="profile">
            <br><img src="Admin_Image.jpg" alt="Admin">
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
                    <a href="..\Medicine\Manage_Medicine.php">Manage Medicine</a>
                    <a href="..\Medicine\Manage_Medicine_Stock.php">Manage Medicine Stock</a>
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
    <div class="main-content">
        <div class="header">

            <div>
                <h1><i class="fa-solid fa-capsules"></i>Manage Medicine Stock</h1>
                <p>Manage Exisiting Medicine Stock</p>
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

            //search items
            document.addEventListener("DOMContentLoaded", function () {
                const medicineInput = document.getElementById("medicine");
                const genericInput = document.getElementById("generic");
                const supplierInput = document.getElementById("supplier");
                const tableRows = document.querySelectorAll("#tbody tr");

                const outOfStockBtn = document.querySelector(".out-of-stock");
                const expiredBtn = document.querySelector(".expired");
                const resetBtn = document.querySelector(".available");

                function tableFilter() {
                    let medicineValue = medicineInput.value.toLowerCase();
                    let genericValue = genericInput.value.toLowerCase();
                    let supplierValue = supplierInput.value.toLowerCase();

                    Array.from(tableRows).forEach(row => {
                        let medicineText = row.children[1].textContent.toLowerCase();
                        let genericText = row.children[3].textContent.toLowerCase();
                        let supplierText = row.children[6].textContent.toLowerCase();

                        if (
                            medicineText.includes(medicineValue) &&
                            genericText.includes(genericValue) &&
                            supplierText.includes(supplierValue)
                        ) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    });
                }

                function filterOutOfStock() {
                    Array.from(tableRows).forEach(row => {
                        let quantity = parseInt(row.children[7].textContent); 
                        row.style.display = quantity === 0 ? "" : "none"; 
                    });
                }

                function filterExpired() {
                    const today = new Date();
                    Array.from(tableRows).forEach(row => {
                        let expireText = row.children[5].textContent.trim(); 
                        let [expMonth, expYear] = expireText.split("/").map(Number);

                        let expireDate = new Date(`20${expYear}`, expMonth - 1); 

                        row.style.display = expireDate < today ? "" : "none"; 
                    });
                }

                function resetFilters() {
                    Array.from(tableRows).forEach(row => {
                        row.style.display = ""; 
                    });
                }

                medicineInput.addEventListener("input", tableFilter);
                genericInput.addEventListener("input", tableFilter);
                supplierInput.addEventListener("input", tableFilter);

                outOfStockBtn.addEventListener("click", filterOutOfStock);
                expiredBtn.addEventListener("click", filterExpired);
                resetBtn.addEventListener("click", resetFilters);
            });

        </script>


        <div class="search-container">
            <div class="search-bar">
                <label for="search" class="search-label">Search:</label>
                <input type="text" id="medicine" placeholder="By Medicine Name" class="search-input">
                <input type="text" id="generic" placeholder="By Generic Name" class="search-input">
                <input type="text" id="supplier" placeholder="By Supplier Name" class="search-input"><br>
            </div>

            <div class="button-group">
                <button class="btn out-of-stock">Out of Stock</button>
                <button class="btn expired">Expired</button>
                <button onclick="location.href='Manage_Medicine_Stock.php'" class="btn available">&#8635;</button>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Medicine Name</th>
                    <th>Packing</th>
                    <th>Generic Name</th>
                    <th>Batch ID</th>
                    <th>Ex. Date (mm/yy)</th>
                    <th>Supplier</th>
                    <th>Qty.</th>
                    <th>M.R.P.</th>
                    <th>Rate</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>

            </thead>
            <tbody id="tbody">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['medicine_name']; ?></td>
                        <td><?php echo $row['packing']; ?></td>
                        <td><?php echo $row['generic_name']; ?></td>
                        <td><?php echo $row['batch_id']; ?></td>
                        <td><?php echo $row['expire_date']; ?></td>
                        <td><?php echo $row['supplier']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['mrp']; ?></td>
                        <td><?php echo $row['rate']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td>
                            <button onclick="location.href='update_Manage_Medicine_Stock.php?id=<?php echo $row['id']; ?>'"
                                class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                        </td>
                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>