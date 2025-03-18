<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Cargills Pharmacy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            background-color: #f5f5f5;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #8B0000;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar-logo {
            color: white;
            margin-right: 10px;
        }

        .navbar-links {
            display: flex;
            gap: 20px;
        }

        .navbar-links a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
        }

        .navbar-links a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .navbar-links i {
            margin-right: 5px;
        }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sign-container {
            width: 90%;
            max-width: 800px;
            aspect-ratio: 16/9;
            background-color: #8B0000;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .welcome-text {
            color: white;
            font-size: 4.5vw;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 30px;
            font-style: italic;
            letter-spacing: 2px;
            text-decoration: underline;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .pharmacy-card {
            background-color: #f0f0f0;
            width: 80%;
            height: 60%;
            border-radius: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
        }

        .pharmacy-content {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .pharmacy-text-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            position: relative;
        }

        .cargills-text {
            color: #222;
            font-size: 1.8vw;
            text-align: center;
            margin-bottom: 5px;
        }

        .pharmacy-text {
            color: #8B0000;
            font-size: 5vw;
            font-weight: bold;
            text-align: center;
        }

        .since-text {
            color: darkgreen;
            font-size: 2vw;
            text-align: center;
            margin-top: 5px;
        }

        .cross-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .cross-container {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .fa-plus {
            color: #FF0000;
            font-size: 4vw;
            font-weight: 900;
        }

        @media (max-width: 768px) {
            .welcome-text {
                font-size: 8vw;
            }
            .pharmacy-text {
                font-size: 9vw;
            }
            .cargills-text {
                font-size: 4vw;
            }
            .since-text {
                font-size: 4vw;
            }
            .fa-plus {
                font-size: 8vw;
            }
            .navbar {
                padding: 10px;
            }
            .navbar-brand {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
<?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pharmacydb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Check if the admin_creaditial table is empty
    $sql = "SELECT COUNT(*) as count FROM admin_credentials";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $isTableEmpty = ($row['count'] == 0);

    // Close the connection
    $conn->close();
?>

    <nav class="navbar">
        <div class="navbar-brand">
            <i class="fas fa-mortar-pestle navbar-logo"></i>
            Cargills Pharmacy
        </div>
        <div class="navbar-links">
            <?php if ($isTableEmpty): ?>
                <a href="register.php"><i class="fas fa-user-plus"></i> Register</a>
            <?php endif; ?>
            <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
        </div>
    </nav>
    
    <div class="main-content">
        <div class="sign-container">
            <div class="welcome-text">WELCOME TO</div>
            <div class="pharmacy-card">
                <div class="pharmacy-content">
                    <div class="pharmacy-text-container">
                        <div class="cargills-text">Cargills</div>
                        <div class="pharmacy-text">PHARMACY</div>
                        <div class="since-text">Since 1844</div>
                    </div>
                    <div class="cross-icon">
                        <div class="cross-container">
                            <i class="fas fa-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>