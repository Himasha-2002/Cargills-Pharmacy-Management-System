<?php 
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Invoice</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/Customer-Invoice.css">
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
                    <a href="..\New\Manage Purchase.php">Manage Supplier</a>
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
                <h1><i class="fa-solid fa-cart-shopping"></i>Customer Invoice</h1>
                <p>Invoice Number - 10003,Invoice Date - 2020-05-06</p>
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
                
                <input type="text" id="voucher" placeholder="Customer Details">
                <input type="text" placeholder="Shop Details">
            </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Medicine Name</th>
                    <th>Expire Dates</th>
                    <th>Quantity</th>
                    <th>MRP</th>
                    <th>Discount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>.....</td>
                    <td>.....</td>
                    <td>.....</td>
                    <td>.....</td>
                    <td>.....</td>
                    <td>.....</td>
                </tr>
                <tr>
                    <td>.....</td>
                    <td>.....</td>
                    <td>.....</td>
                    <td>.....</td>
                    <td>.....</td>
                    <td>.....</td>
                </tr>
                <tr>
                    <td>.....</td>
                    <td>.....</td>
                    <td>.....</td>
                    <td>.....</td>
                    <td>.....</td>
                    <td>.....</td>
                </tr>
            </tbody>
        </table>
        <div class="print-settings">
            <h2>Print</h2>
            <div class="settings-group">
              <label>Destination</label>
              <select>
                <option>Save as PDF</option>
              </select>
            </div>
            <div class="settings-group">
              <label>Pages</label>
              <select>
                <option>All</option>
              </select>
            </div>
            <div class="settings-group">
              <label>Pages per sheet</label>
              <select>
                <option>1</option>
                <option>2</option>
                <option>4</option>
                <option>6</option>
                <option>8</option>
              </select>
            </div>
            <div class="settings-group">
              <label>Margins</label>
              <select>
                <option>Default</option>
              </select>
            </div>
            <div class="settings-group">
              <label>
                  <label>Options</label>
                  <div class="checkbox-group">
                    <input type="checkbox" id="headers-footers" name="headers-footers">
                    <label for="headers-footers">Headers and Footers</label>
                  </div>
                  
                  <div class="checkbox-group">
                    <input type="checkbox" id="background-graphics" name="background-graphics">
                    <label for="background-graphics">Background Graphics</label>
                  </div> 
              </label>
            </div>
            <div class="buttons">
              <button class="save-button">Save</button>
              <button class="cancel-button">Cancel</button>
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
        // JavaScript to handle sidebar toggle on smaller screens
            function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
            }
            </script>
     
        
    </body>
</html>