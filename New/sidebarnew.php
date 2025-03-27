<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sidebar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebarnew.css">
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <br><img src="Admin.jpg" alt="Admin">
            <h3>ADMIN</h3>
        </div>
        <div class="menu">
                <a href="#"><i class="fas fa-th-large"></i> Dashboard</a><br>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-file-invoice"></i> Invoice<span class="toggle"><</span></a>
                <div class="dropdown-content">
                    <a href="#">New Invoice</a>
                    <a href="#">Manage Invoice</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-users"></i> Customer<span class="toggle"><</span></a>
                <div class="dropdown-content">
                    <a href="#">Add Customer</a>
                    <a href="#">Manage Customer</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-capsules"></i> Medicine<span class="toggle"><</span></a>
                <div class="dropdown-content">
                    <a href="#">Add Medicine</a>
                    <a href="#">Manage Medicine</a>
                    <a href="#">Manage Medicine Stock</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fas fa-truck"></i> Supplier<span class="toggle"><</span></a>
                <div class="dropdown-content">
                    <a href="#">Add Supplier</a>
                    <a href="#">Manage Supplier</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-cart-shopping"></i> Purchase<span class="toggle"><</span></a>
                <div class="dropdown-content">
                    <a href="#">Add Purchase</a>
                    <a href="#">Manage Purchase</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fas fa-chart-bar"></i> Report<span class="toggle"><</span></a>
                <div class="dropdown-content">
                    <a href="#">Sales Report</a>
                    <a href="#">Purchase Report</a>
                </div>
            </div>   
        </div>
    </div>
    <div class="main-content">
        <div class="header">           
            <div>
                <h1><i class="fa-solid fa-cart-shopping"></i>Add Purchase</h1>
                <p>Add New Purchase</p>
            </div>   
            <!--Setting icon-->     
            <div class="settings-dropdown">
                <a href="#"><i class="fas fa-cog settings-icon"></i></a>
                <div class="settings-menu">
                    <a href="#"><i class="fas fa-user"></i>My Profile</a>
                    <a href="#"><i class="fas fa-key"></i>Change Password</a>
                    <a href="#"><i class="fas fa-sign-out-alt"></i>Logout</a>
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
    