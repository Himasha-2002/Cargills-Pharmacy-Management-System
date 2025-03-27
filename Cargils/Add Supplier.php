<?php 
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

//add a supplier
if(isset($_POST['submit'])){
    $name = ucwords($_POST['name']);
    $email = $_POST['email'];
    $contact = ucwords($_POST['contact']);
    $address = ucwords($_POST['address']);

    //check contact number is already wxist
    $check_email_sql = "SELECT * FROM supplier WHERE email = '$email'";
    $res_email_check = mysqli_query($conn, $check_email_sql);

    if (mysqli_num_rows($res_email_check) > 0) {
        echo '<script>alert("Email is already exist. Please enter different email.")</script>';
    } else {
        $sql = "INSERT INTO supplier(name, email, contact, address) VALUES('$name', '$email', '$contact', '$address')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo '<script>alert("Supplier added successfully.")</script>';
        } else {
            echo '<script>alert("Something went wrong.")</script>';
        }
    } 
}

//close connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/add-supplier.css">
</head>
<body>
<!--sidebar-->
    <div class="sidebar">
        <div class="profile">
            <br><img src="admin.jpg" alt="Admin">
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
                <a href="..\New\purchase Report.php">Purchase Report</a>
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
                <h1><i class="fa-solid fa-users"></i>Add Supplier</h1>
                <p>Add New Supplier</p>
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
        <!--form-container-->
        <div class="form-container">
            <form method="post" action="">
                <label for="supplier-name">Supplier Name:</label>
                <input type="text" id="supplier-name" name="name" placeholder="Supplier  Name" required>

                <label for="supplier-email">Supplier Email:</label>
                <input type="email" id="supplier-email" name="email" placeholder="Supplier Email" required>

                <label for="contact-number">Supplier Contact Number:</label>
                <input type="text" id="contact-number" name="contact" placeholder="Contact Number" required>

                <label for="Address">Supplier Address</label>
                <input type="text" id="Address" name="address" placeholder="Address" required>
                
                <br>
                 

                <button name="submit" type="submit">ADD</button>
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
        //email validation
         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address.');
            isValid = false;
        }
            
        </script>
    </body>
    </html>