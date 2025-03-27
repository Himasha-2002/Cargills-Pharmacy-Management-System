<?php 
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
    header("location:../PMS/login.php");
    exit();
}

//database connection
include('../db_connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/reset_password.css">
    <title>Reset Password</title>

</head>

<body>
    <div class="container">
        <div class="card"><br>
            <div class="profile-img">
                <img src="profile-icon.jpg" Profile Icon>
            </div>
            <h2>Reset Password</h2><br>

            <form method="post" action="verify.php">
                <div class="text-input">
                    <i class="ri-user-fill"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div><br>
                <div class="text-input">
                    <i class="ri-lock-fill"></i>
                    <input type="password" name="new_password" placeholder="Enter New Password" required>
                </div><br>
                <div class="text-input">
                    <i class="ri-lock-fill"></i>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div><br><br><br>
                <button type="submit" class="btn reset-btn">Reset Password</button><br><br>
                <a href="login.php" class="login-link">Login Here</a>
            </form>

        </div>
    </div>
</body>

</html>