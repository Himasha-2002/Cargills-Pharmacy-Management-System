<?php
session_start();

// Include database connection
require 'php/db_connection.php';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Query to check credentials
    $sql = "SELECT * FROM admin_credentials WHERE USERNAME = ? AND PASSWORD = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $input_username, $input_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Valid credentials
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $input_username;

        // Update IS_LOGGED_IN status
        $update_sql = "UPDATE admin_credentials SET IS_LOGGED_IN = TRUE WHERE USERNAME = ?";
        $update_stmt = $con->prepare($update_sql);
        $update_stmt->bind_param("s", $input_username);
        $update_stmt->execute();

        header("Location: home.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }

    $stmt->close();
}

// Handle forgot password form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];

    // Verify email and contact number
    $sql = "SELECT * FROM admin_credentials WHERE EMAIL = ? AND CONTACT_NUMBER = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $email, $contact_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Redirect to PasswordReset.php with email and contact number
        header("Location: PasswordReset.php?email=" . urlencode($email) . "&contact_number=" . urlencode($contact_number));
        exit();
    } else {
        echo "<script>alert('Invalid email or contact number');</script>";
    }

    $stmt->close();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargills Pharmacy Login</title>
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
        .login-container {
            background-color: #BF3131; /* Updated color */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            color: white; /* Text color for better contrast */
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: white;
            font-size: 24px; /* Adjust font size as needed */
            font-weight: bold;
            text-transform: uppercase;
        }
        .login-container h2 span {
            display: block;
            font-size: 18px; /* Smaller font size for "Login" */
            font-weight: normal;
            margin-top: 5px;
        }
        .login-container img {
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
        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container input[type="email"],
        .login-container input[type="number"] {
            width: 100%;
            padding: 12px 12px 12px 40px; /* Add padding for the icon */
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .login-container input[type="submit"] {
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
        .login-container input[type="submit"]:hover {
            background-color: red;
            color: white;
        }
        .forgot-password {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: white; /* Updated color for better contrast */
            text-decoration: none;
            font-size: 14px;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
        #forgot-password-form {
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-container" id="login-form">
        <img src="images/prof.png" alt="Profile Image">
        <h2>Cargills Pharmacy<br><span>Login</span></h2>
        <form name="login-form" class="login-form" action="login.php" method="post">
            <div class="input-container">
                <i class="fas fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="input-container">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <input type="submit" name="login" value="Login">
        </form>
        <a href="#" class="forgot-password" onclick="displayForgotPasswordForm();">Forgot Password</a>
    </div>

    <div class="login-container" id="forgot-password-form">
        <img src="images/prof.png" alt="Profile Image">
        <h2>Forgot Password</h2>
        <form name="forgot-password-form" class="forgot-password-form" action="login.php" method="post">
            <div id="email-number-fields">
                <p>Enter email and contact number below to reset username and password</p>
                <div class="input-container">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="input-container">
                    <i class="fas fa-phone"></i>
                    <input type="number" id="contact_number" name="contact_number" placeholder="Enter contact number" required>
                </div>
                <input type="submit" name="reset_password" value="Verify">
            </div>
        </form>
        <a href="#" class="forgot-password" onclick="displayLoginForm();">Login here</a>
    </div>

    <script>
        function displayForgotPasswordForm() {
            document.getElementById("login-form").style.display = "none";
            document.getElementById("forgot-password-form").style.display = "block";
        }

        function displayLoginForm() {
            document.getElementById("forgot-password-form").style.display = "none";
            document.getElementById("login-form").style.display = "block";
        }
    </script>
</body>
</html>