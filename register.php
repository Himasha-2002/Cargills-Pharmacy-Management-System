<?php
session_start();

// Include database connection
require 'php/db_connection.php';

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];

    // Check if the username already exists
    $check_sql = "SELECT * FROM admin_credentials WHERE USERNAME = ?";
    $check_stmt = $con->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose a different username.');</script>";
    } else {
        // Insert new admin credentials into the database
        $insert_sql = "INSERT INTO admin_credentials (USERNAME, PASSWORD, EMAIL, CONTACT_NUMBER, IS_LOGGED_IN) VALUES (?, ?, ?, ?, FALSE)";
        $insert_stmt = $con->prepare($insert_sql);
        $insert_stmt->bind_param("sssi", $username, $password, $email, $contact_number);

        if ($insert_stmt->execute()) {
            echo "<script>alert('Registration successful! You can now login.');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }

        $insert_stmt->close();
    }

    $check_stmt->close();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargills Pharmacy Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background-color: #BF3131; /* Updated color */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            color: white; /* Text color for better contrast */
        }
        .register-container h2 {
            margin-bottom: 20px;
            color: white;
            font-size: 24px; /* Adjust font size as needed */
            font-weight: bold;
            text-transform: uppercase;
        }
        .register-container h2 span {
            display: block;
            font-size: 18px; /* Smaller font size for "Register" */
            font-weight: normal;
            margin-top: 5px;
        }
        .register-container img {
            width: 100px; /* Adjust the size as needed */
            height: 100px; /* Adjust the size as needed */
            margin-bottom: 20px;
            border-radius: 50%; /* Makes the image circular */
            border: 3px solid white; /* Adds a round border */
            padding: 5px; /* Optional: Adds some space between the image and the border */
        }
        .input-container {
            position: relative;
            margin: 10px 0;
        }
        .input-container i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #BF3131; /* Icon color */
        }
        .register-container input[type="text"],
        .register-container input[type="password"],
        .register-container input[type="email"],
        .register-container input[type="number"] {
            width: 100%;
            padding: 12px 12px 12px 40px; /* Add padding for the icon */
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .register-container input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: white;
            border: none;
            border-radius: 5px;
            color: black;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        .register-container input[type="submit"]:hover {
            background-color: red;
            color: white;
        }
        .login-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: white; /* Updated color for better contrast */
            text-decoration: none;
            font-size: 14px;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <img src="images/prof.png" alt="Profile Image">
        <h2>Cargills Pharmacy<br><span>Register</span></h2>
        <form name="register-form" class="register-form" action="register.php" method="post">
            <div class="input-container">
                <i class="fas fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="input-container">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-container">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-container">
                <i class="fas fa-phone"></i>
                <input type="number" id="contact_number" name="contact_number" placeholder="Contact Number" required>
            </div>
            <input type="submit" name="register" value="Register">
        </form>
        <a href="login.php" class="login-link">Already have an account? Login here</a>
    </div>
</body>
</html>