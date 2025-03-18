<?php
session_start();

// Include database connection
require 'php/db_connection.php';

// Handle password reset form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
    } else {
        // Update the password in the database
        $update_sql = "UPDATE admin_credentials SET USERNAME = ?, PASSWORD = ? WHERE EMAIL = ? AND CONTACT_NUMBER = ?";
        $update_stmt = $con->prepare($update_sql);
        $update_stmt->bind_param("ssss", $new_username, $new_password, $email, $contact_number);

        if ($update_stmt->execute()) {
            echo "<script>alert('Password updated successfully! You can now login with your new credentials.');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Failed to update password. Please try again.');</script>";
        }

        $update_stmt->close();
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - Cargills Pharmacy</title>
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
        .reset-container {
            background-color: #BF3131; /* Updated color */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            color: white; /* Text color for better contrast */
        }
        .reset-container h2 {
            margin-bottom: 20px;
            color: white;
            font-size: 24px; /* Adjust font size as needed */
            font-weight: bold;
            text-transform: uppercase;
        }
        .reset-container img {
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
        .reset-container input[type="text"],
        .reset-container input[type="password"],
        .reset-container input[type="email"],
        .reset-container input[type="number"] {
            width: 100%;
            padding: 12px 12px 12px 40px; /* Add padding for the icon */
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .reset-container input[type="submit"] {
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
        .reset-container input[type="submit"]:hover {
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
    <div class="reset-container">
        <img src="images/prof.png" alt="Profile Image">
        <h2>Reset Password</h2>
        <form name="reset-password-form" class="reset-password-form" action="PasswordReset.php" method="post">
            <div class="input-container">
                <i class="fas fa-user"></i>
                <input type="text" id="new_username" name="new_username" placeholder="Enter new username" required>
            </div>
            <div class="input-container">
                <i class="fas fa-lock"></i>
                <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>
            </div>
            <div class="input-container">
                <i class="fas fa-key"></i>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
            </div>
            <!-- Hidden fields to store email and contact number -->
            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
            <input type="hidden" name="contact_number" value="<?php echo $_GET['contact_number']; ?>">
            <input type="submit" name="update_password" value="Reset Password">
        </form>
        <a href="login.php" class="login-link">Back to Login</a>
    </div>
</body>
</html>