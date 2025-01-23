<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sales report</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* General styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #f0f0f0;
        }

        /* Sidebar */
        .sidebar {
            width: 15%;
            background-color: #7c0d0d;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 0;
        }

        .sidebar .profile {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .sidebar .profile h3 {
            font-size: 18px;
            font-weight: bold;
            font-size: 25px;
            font-family:'Times New Roman';
        }

        .sidebar .menu {
            width: 100%;
        }

        .sidebar .menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s;
            font-weight: bold;
        }

        .sidebar .menu a:hover {
            background-color: #4e0312;
        }

        .sidebar .menu a i {
            margin-right: 10px;
        }
        /* Dropdown styles */
        .dropdown {
            width: 100%;
        }

        .dropdown-content {
            display: none;
            flex-direction: column;
            background-color: #ad5062;
            border: 1px solid #800000;
        }

        .dropdown-content a {
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            font-size: 9px;
        }

        .dropdown-content a:hover {
            background-color: #800029;
        }

       
        .dropdown .toggle {
            margin-left: auto;
            font-size: 18px;
            cursor: pointer;
        }

      
        .main-content {
            flex: 1;
            background-color: #d5d4d4;
            padding: 20px;
        }

        .header {
            border-bottom: 5px solid #800000;
            margin-bottom: 50px;
            display: flex;
            justify-content: space-between;
            align-items: Right;
            background-color: #b8b6b6;
            padding: 10px 20px;
            border-radius: 5px;
        }
        

        .header h1 {
            display: flex;
            align-items: center; 
            gap: 20px;
            color: #040404;
            margin: 0;
            font-size: 35px;
            font-family: 'Times New Roman', Times, serif;
            font-style: bold;
        }
        .settings-btn {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
}

.overview {
  display: grid;
  grid-template-columns: repeat(3, 2fr);
  gap: 40px;
  margin: 10px;
}



.overview3 {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 40px;
  margin: 10px;
}
.overview2 {
  display: grid;
  margin: 10px;
  width: 70%;
  border-color: #800029;
}

.card {
  background-color: #c2aaaa;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(106, 11, 11, 0.1);
  text-align: center;
}

.actions {
  display: grid;
  grid-template-columns: repeat(4, 2fr);
  gap: 10px;
}

.action-btn {
  background-color: #969090;
  color: #fff;
  padding:50px;
  border: none;
  border: 2px solid rgb(53, 4, 4);
  border-radius: 10px;
  cursor: pointer;
  flex: 1 1 calc(10% - 3px);
  text-align: center;
}
.action-btn:hover {
  background-color: #d5c2c2;
}
.styled-hr {
            border: none; 
            height: 5px; 
            background-color: #800000;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            font-family: Iskoola Pota;
        }

        .actions button:hover {
            background-color: #660000;
        }

        .total-sales {
            font-size: 16px;
            margin-top: 20px;
            text-align: right;
            font-family: Aptos Display;
            text-align: left;
        }
        .settings-dropdown {
        position: relative;
        display: inline-block;
        }

        .settings-icon {
        right: 50px;
        font-size: 30px;
        color: #040404;
        cursor: pointer;
        text-decoration: none;
        }

        .settings-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 40px;
        background-color: #ad5062;
        border: 1px solid #800000;
        border-radius: 5px;
        border-width: 2px;
        width: 150px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        }

        .settings-menu a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            font-family: Arial, sans-serif;
            transition: background-color 0.3s;
            gap: 10px; 
        }

        .settings-menu a:hover {
        background-color: #4e0312;
        }





    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <br><img src="Admin.jpg" alt="Admin">
            <h3>ADMIN</h3>
        </div>
        <div class="menu">
                <a href="..\dashboard\Dashboard.html"><i class="fas fa-th-large"></i> Dashboard</a>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-file-invoice"></i> Invoice<span class="toggle"><</span></a>
                <div class="dropdown-content">
                    <a href="..\Cargils\New Invoice.html">New Invoice</a>
                    <a href="..\dashboard\Manage Invoice.html">Manage Invoice</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-users"></i> Customer<span class="toggle"><</span></a>
                <div class="dropdown-content">
                    <a href="..\New\Add Customer.html">Add Customer</a>
                    <a href="..\Naduni\Manage Customer.html">Manage Customer</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-capsules"></i> Medicine<span class="toggle"><</span></a>
                <div class="dropdown-content">
                    <a href="..\Medicine\Add_Medicine.html">Add Medicine</a>
                    <a href="..\Medicine\Manage_medicine_Stock.html">Manage Medicine</a>
                    <a href="..\Medicine\Manage_medicine.html">Manage Medicine Stock</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fas fa-truck"></i> Supplier<span class="toggle"><</span></a>
                <div class="dropdown-content">
                    <a href="..\Cargils\Add Supplier.html">Add Supplier</a>
                    <a href="..\Cargils\Manage Supplier.html">Manage Supplier</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fa-solid fa-cart-shopping"></i> Purchase<span class="toggle"><</span></a>
                <div class="dropdown-content">
                    <a href="..\New\Add Purchase.html">Add Purchase</a>
                    <a href="..\New\Manage Purchase.html">Manage Purchase</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#"><i class="fas fa-chart-bar"></i> Report<span class="toggle"><</span></a>
                <div class="dropdown-content">
                    <a href="..\dashboard\Sales report.html">Sales Report</a>
                    <a href="..\New\Purchase Report.html">Purchase Report</a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="header">           
            <div>
                <h1><i class="fa-solid fa-cart-shopping"></i>Dashboard</h1>
            </div>       
            <div class="settings-dropdown">
                <a href="#"><i class="fas fa-cog settings-icon"></i></a>
                <div class="settings-menu">
                    <a href="..\Naduni\Profile.html"><i class="fas fa-user"></i>My Profile</a>
                    <a href="..\Cargils\Password.html"><i class="fas fa-key"></i>Change Password</a>
                    <a href="#"><i class="fas fa-sign-out-alt"></i>Logout</a>
                </div>
            </div>
        </div>
        <div class="overview3">
        <section class="overview">
            <div class="card">Total Customer</div>
            <div class="card">Total Supplier</div>
            <div class="card">Total Medicine</div>
            <div class="card">Out Of Stock</div>
            <div class="card">Expired</div>
            <div class="card">Total Invoice</div>
            
          </section>
          <div class="overview2">
            <div class="card">
                <h3>Today's Report</h3></br>
                <p>Total Sales: Rs.0</p></br>
                <p>Total Purchase: Rs.0</p></br>
              </div>
          </div>
        </div>
        </br></br></br>
        <hr class="styled-hr"></br></br>
          <section class="actions">
            <button class="action-btn"><i class="fa-solid fa-file-invoice"></i>Create New Invoice </button>
            <button class="action-btn"><i class="fa-solid fa-users"></i>Add New Customer</button>
            <button class="action-btn"><i class="fa-solid fa-capsules"></i>Add New Medicine</button>
            <button class="action-btn"><i class="fas fa-truck"></i>Add New Supplier</button>
            <button class="action-btn"><i class="fa-solid fa-cart-shopping"></i>Add New Purchase</button>
            <button class="action-btn"><i class="fas fa-chart-bar"></i>Sales Report</button>
            <button class="action-btn"><i class="fas fa-chart-bar"></i>Purchase Report</button>
        </section>
        </main>
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