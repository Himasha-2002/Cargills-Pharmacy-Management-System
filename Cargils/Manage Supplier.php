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
$sql = "SELECT * FROM supplier ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

//delete a customer
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $delete_sql = "DELETE FROM supplier WHERE id = '$id'";
    $delete_res = mysqli_query($conn, $delete_sql);

    if($delete_res){
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
    <title>Manage Supplier</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/manage-supplier.css">
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
    <!--sidebar Toggle button for smaller screen-->
    <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

    <div class="main-content">
        <!--header-->
        <div class="header">
            <div>
                <h1><i class="fas fa-truck"></i>Manage Supplier</h1>
                <p>Manage Existing Supplier</p>
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
        <!--search section-->
        <div class="search-section">
            <label for="Search"><span>Search:</span></label>
            <div class="search-container">
                <input type="text" placeholder="Search Supplier" input type="text" id="searchInput" placeholder="Search Customer" class="form-control"
                onkeyup="searchCustomer()">
                <i class="fa fa-search icon"></i>
            </div>
        </div><br>
        <!--table-->

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>

            </thead>
            <tbody>
            <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr class="customer-item">
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td>
                            <button onclick="location.href='update_supplier.php?id=<?php echo $row['id']; ?>'"
                                class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                            <a onclick="confirm ('Are you sure, Do you want to delete this Customer? ')"
                            href="Manage Supplier.php?id=<?php echo $row['id'] ?>"><button class="btn btn-danger"><i class="bi bi-trash3"></i></button></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
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

        //search function
        function searchCustomer() {
                let input = document.getElementById("searchInput").value.toLowerCase();
                let customers = document.querySelectorAll(".customer-item");

                customers.forEach(function (customer) {
                    let name = customer.textContent.toLowerCase();
                    if (name.includes(input)) {
                        customer.style.display = "table-row";
                    } else {
                        customer.style.display = "none";
                    }
                });
        }

    </script>
</body>

</html>