<?php
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

//add new customer
if (isset($_POST['submit'])) {
    $customer_name = ucwords($_POST['customer-name']);
    $contact_number = $_POST['contact-number'];
    $address = ucwords($_POST['address']);
    $doctor_name = ucwords($_POST['doctor_name']);
    $doctor_address = ucwords($_POST['doctor_address']);

    //check contact number is already wxist
    $check_contact_sql = "SELECT * FROM customers WHERE contact = '$contact_number'";
    $res_contact_check = mysqli_query($conn, $check_contact_sql);

    if (mysqli_num_rows($res_contact_check) > 0) {
        echo '<script>alert("Contact number already exist. Please enter different number.")</script>';
    } else {
        $sql = "INSERT INTO customers(customer_name, contact, address, doctor_name, doctor_address) VALUES('$customer_name', '$contact_number', '$address', '$doctor_name', '$doctor_address')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo '<script>alert("Customer added successfully.")</script>';
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
    <title>Add Customer</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/Add-Customer.css">
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
                <a href="#"><i class="fa-solid fa-file-invoice"></i> Invoice<span class="toggle">
                        < </span></a>
                <div class="dropdown-content">
                    <a href="..\Cargils\New Invoice.php">New Invoice</a>
                    <a href="..\dashboard\Manage Invoice.php">Manage Invoice</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-users"></i> Customer<span class="toggle">
                        < </span></a>
                <div class="dropdown-content">
                    <a href="..\New\Add Customer.php">Add Customer</a>
                    <a href="..\Naduni\Manage Customer.php">Manage Customer</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-capsules"></i> Medicine<span class="toggle">
                        < </span></a>
                <div class="dropdown-content">
                    <a href="..\Medicine\Add_Medicine.php">Add Medicine</a>
                    <a href="..\Medicine\Manage_medicine.php">Manage Medicine</a>
                    <a href="..\Medicine\Manage_medicine_Stock.php">Manage Medicine Stock</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fas fa-truck"></i> Supplier<span class="toggle">
                        < </span></a>
                <div class="dropdown-content">
                    <a href="..\Cargils\Add Supplier.php">Add Supplier</a>
                    <a href="..\Cargils\Manage Supplier.php">Manage Supplier</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-cart-shopping"></i> Purchase<span class="toggle">
                        < </span></a>
                <div class="dropdown-content">
                    <a href="..\New\Add Purchase.php">Add Purchase</a>
                    <a href="..\New\Manage Purchase.php">Manage Purchase</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fas fa-chart-bar"></i> Report<span class="toggle">
                        < </span></a>
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
                <h1><i class="fa-solid fa-users"></i>Add Customer</h1>
                <p>Add New Customer</p>
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
            <form method="post" action="#">
                <label for="customer-name">Customer Name:</label>
                <input type="text" id="customer-name" name="customer-name" placeholder="Name" required>

                <label for="contact-number">Contact Number:</label>
                <input type="text" id="contact-number" name="contact-number" placeholder="Contact Number" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" placeholder="Address" required>

                <label for="doctor-name">Doctor's Name:</label>
                <input type="text" id="doctor-name" name="doctor_name" placeholder="Doctor's Name" required>

                <label for="doctor-address">Doctor's Address:</label>
                <input type="text" id="doctor-address" name="doctor_address" placeholder="Doctor's Address" required>

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
        </script>

</body>

</html>