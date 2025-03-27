<?php
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

//retrieve all suppliers
$supplier_sql = "SELECT name FROM supplier";
$res_supplier = mysqli_query($conn, $supplier_sql);

//retrieve all customers details
$id = $_GET['id'];
$sql = "SELECT * FROM purchases WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

//update customer
if (isset($_POST['submit'])) {
    $supplier = $_POST['supplier'];
    $payment = $_POST['payment'];

    $update_sql = "UPDATE purchases SET supplier = '$supplier', payment_type = '$payment' WHERE id = '$id'";
    $update_res = mysqli_query($conn, $update_sql);

    if($update_res) {
        header("Location:Manage Purchase.php");
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
    <title>Update purchases</title>
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
                <h1><i class="fa-solid fa-users"></i>Update Purchases</h1>
                <p>Update Existing Purchases</p>


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

        <!--Customer update form-->

        <!--form-container-->
        <div class="form-container">
        <form method="post" action="">
                <label for="supplier">Supplier:</label>
                    <select name="supplier" id="supplier">
                        <option disabled value="<?php echo $row['supplier']; ?>" selected><?php echo $row['supplier']; ?></option>
                        <?php 
                        while($row_supplier = mysqli_fetch_assoc($res_supplier)){
                        ?>
                        <option value="<?php echo $row_supplier['name']; ?>"><?php echo $row_supplier['name']; ?></option>
                        <?php 
                        }
                        ?>
                    </select>

                <label for="inv_number">Invoice Number:</label>
                <input type="text" id="inv_number" name="inv_number" value="<?php echo $row['inv_number']; ?>" readonly placeholder="Invoice Number">

                <label for="date">Purchase Date:</label>
                <input type="text" id="date" name="date" value="<?php echo $row['date']; ?>" readonly placeholder="Purchase Date">

                <label for="payment">Payment Method:</label>
                <select name="payment" id="">
                    <option disabled value="<?php echo $row['payment_type']; ?>"><?php echo $row['payment_type']; ?></option>
                    <option value="Cash Payment">Cash Payment</option>
                    <option value="Card Payment">Card Payment</option>
                </select>

                <label for="amount">Amount:</label>
                <input type="text" id="amount" readonly name="total" readonly value="<?php echo $row['grand_total']; ?>" placeholder="Total Amount">

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