<?php
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

//retrieve all customers details
$id = $_GET['id'];
$sql = "SELECT * FROM supplier WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

//update customer
if (isset($_POST['submit'])) {
    $name = ucwords($_POST['name']);
    $email = $_POST['email'];
    $contact = ucwords($_POST['contact']);
    $address = ucwords($_POST['address']);

    $update_sql = "UPDATE supplier SET name = '$name', email = '$email', contact = '$contact', address = '$address' WHERE id = '$id'";
    $update_res = mysqli_query($conn, $update_sql);

    if($update_res) {
        header("Location:Manage Supplier.php");
        exit();
    } else{
        echo '<script>alert("Something went wrong.")</script>';
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
    <title>Manage Customer</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/manage-supplier.css">
</head>

<body>
    <!--sidebar-->
    <div class="sidebar">
        <div class="profile">
            <br><img src="Admin.jpg" alt="Admin">
            <h3>ADMIN</h3>
        </div>
        <div class="menu">
            <a href="..\dashboard\Dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a>
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
                    <a href="..\Medicine\Manage_medicine_Stock.php">Manage Medicine</a>
                    <a href="..\Medicine\Manage_medicine.php">Manage Medicine Stock</a>
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
                <h1><i class="fa-solid fa-users"></i>Update Supplier</h1>
                <p>Update Existing Supplier</p>


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

        <!--Supplier update form-->

        <!--form-container-->
        <div class="form-container">
            <form method="post" action="#">
                <label for="supplier-name">Supplier Name:</label>
                <input type="text" id="supplier-name" name="name" value="<?php echo $row['name']; ?>" placeholder="Supplier Name">

                <label for="supplier-email">Supplier Email:</label>
                <input type="email" id="supplier-email" name="email" value="<?php echo $row['email']; ?>" placeholder="Supplier Email">

                <label for="contact-number">Supplier Contact Number:</label>
                <input type="text" id="contact-number" name="contact" value="<?php echo $row['contact']; ?>" placeholder="Contact Number">

                <label for="Address">Supplier Address</label>
                <input type="text" id="Address" name="address" value="<?php echo $row['address']; ?>" placeholder="Address">
                
                <br>
                 
                <button name="submit" type="submit">UPDATE</button>
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

    </script>


</body>


</html>