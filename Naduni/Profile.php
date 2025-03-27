<?php
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

//retireve user details
$email = $_SESSION['user_email'];
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

//update user details
if(isset($_POST['submit'])){
    $pharmacy_name = $_POST['pharmacy_name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $username = $_POST['username'];

    $sql_update = "UPDATE users SET pharmacy_name = '$pharmacy_name', address = '$address', contact = '$contact', username = '$username' WHERE email = '$email'";
    $res_update = mysqli_query($conn, $sql_update);

    if($res_update){
        echo '<script>alert("User updated successfully.")</script>';
        header("location:Profile.php");
        exit();
    } else{
        echo '<script>alert("Something went wrong.")</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assest/Profile.css">
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
                    <a href="..\Medicine\Manage_medicine_Stock.php">Manage Medicine</a>
                    <a href="..\Medicine\Manage_medicine.php">Manage Medicine Stock</a>
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
                <h1><i class="fas fa-user"></i>Profile</h1>
                <p>Manage Admin Details</p>
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
        </script>

        <div class="form-container">
            <form method="post" action="">

                <label for="pharmacyName">Pharmacy Name:</label>
                <input type="text" id="pharmacyName" name="pharmacy_name" value="<?php echo $row['pharmacy_name']; ?>" placeholder="Enter pharmacy name">

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>" placeholder="Enter address">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" readonly value="<?php echo $row['email']; ?>" placeholder="Enter email">

                <label for="contact">Contact Number:</label>
                <input type="text" id="contact" name="contact" value="<?php echo $row['contact']; ?>" placeholder="Enter contact number">

                <label for="username">User Name:</label>
                <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>" placeholder="Enter username">

                <div class="buttons">
                    <button type="submit" name="submit" class="btn update">Update</button>
                    <button type="reset" onclick="location.href='../dashboard/Dashboard.php'" class="btn cancel">Cancel</button>
                </div>
            </form>
</body>

</html>