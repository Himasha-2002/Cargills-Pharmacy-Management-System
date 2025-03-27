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

//add a medicine
if(isset($_POST['submit'])){
    $medicine_name = ucwords($_POST['medicine_name']);
    $packing = $_POST['packing']." TAB";
    $generic_name = ucwords($_POST['generic_name']);
    $supplier = ucwords($_POST['supplier']);

    //check medicine already exist
    $check_medi_sql = "SELECT * FROM medicine WHERE medicine_name = '$medicine_name'";
    $res_medicine = mysqli_query($conn, $check_medi_sql);

    if(mysqli_num_rows($res_medicine) > 0){
        echo '<script>alert("The medicine is already exist.")</script>';
    } else{
        $sql = "INSERT INTO medicine(medicine_name, packing, generic_name, supplier) VALUES('$medicine_name', '$packing', '$generic_name', '$supplier')";
        $result = mysqli_query($conn, $sql);
        if($result) {
            echo '<script>alert("Medicine added successfully.")</script>';
        } else{
            echo '<script>alert("Something went wrong.")</script>';
        }
    }
}

//close connection
mysqli_close($conn);

?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medicine</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/Add_Medicine.css">
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
                    <a href="..\Cargils\Manage Invoice.php ">Manage Invoice</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-users"></i> Customer<span class="toggle">
                        <</span></a>
                <div class="dropdown-content">
                    <a href="..\New\Add Customer.php">Add Customer</a>
                    <a href="#">Manage Customer</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-capsules"></i> Medicine<span class="toggle">
                        <</span></a>
                <div class="dropdown-content">
                    <a href="#">Add Medicine</a>
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
    <div class="main">
    <div class="main-content">
        <div class="header">
            <div>
                <h1><i class="fa-solid fa-capsules"></i>Add Medicine</h1>
                <p>Add New Medicine</p>
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
        </div>

        <div class="form-container">
            <form method="post" action="">
                <label for="medicine-name">Medicine Name:</label>
                <input type="text" id="medicine-name" name="medicine_name" placeholder="Medicine Name" required>

                <label for="packing">Packing:</label>
                <input type="text" id="packing" name="packing" placeholder="Packing e.g.10 TAB" required>

                <label for="generic-name">Generic Name:</label>
                <input type="text" id="generic-name" name="generic_name" placeholder="Generic Name" required>

                <label for="supplier">Supplier:</label>
                <select name="supplier" id="supplier" required>
                    <option value="" selected>Select a supplier</option>
                    <?php 
                    while($row_supplier = mysqli_fetch_assoc($res_supplier)){
                    ?>
                    <option value="<?php echo $row_supplier['name']; ?>"><?php echo $row_supplier['name']; ?></option>
                    <?php 
                    }
                    ?>
                </select>

                <a style="text-decoration:none;" href="../Cargils/Add Supplier.php"><span class="add-supplier">+ Add New Supplier</span></a><br><br><br><br>

                <button name="submit" type="submit">ADD</button>
            </form>
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
</body>

</html>