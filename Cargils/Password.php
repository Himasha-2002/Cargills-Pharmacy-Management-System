<?php 
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

//reset password
if(isset($_POST['submit'])){
    $email = $_SESSION['user_email'];
    $old_password = $_POST['old_password'];

    $sql_check_password = "SELECT * FROM users WHERE email = '$email'";
    $res_check_password = mysqli_query($conn, $sql_check_password);
    $row_password = mysqli_fetch_assoc($res_check_password);

    $table_old_password = $row_password['password'];

    if($old_password === $table_old_password){
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if($new_password === $confirm_password){
            $sql_update = "UPDATE users SET password = '$new_password'";
            $res_update = mysqli_query($conn, $sql_update);

            if($res_update){
                echo '<script>alert("Password is updated.")</script>';
            } else{
                echo '<script>alert("Something went wrong.")</script>';
            }
        } else{
            echo '<script>alert("Password does not match.")</script>';
        }
    } else{
        echo '<script>alert("Password is incorrect.")</script>';
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
    <title>Change Password</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/password.css">
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
                <h1><i class="fa-sharp fa-solid fa-key" style="color: #000000;"></i>Change Password</h1>
                <p>Set New Password</p>
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
        <!--Form container-->
        <div class="form-container">
            <form action="" method="POST">
                <label for="old-password">Old Password:</label>
                <input type="password" id="old-password" name="old_password" placeholder="Old Password" required>

                <label for="new-password">New Password:</label>
                <input type="password" id="new-password" name="new_password" placeholder="New Password" required>

                <label for="confirm-password">Confirm New Password:</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password" required>
            <div class="button-group">
                <button type="submit" name="submit" >Reset Password</button>
                <button type="button" onclick="location.href='../Naduni/Profile.php'">Profile</button>
            </div>
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