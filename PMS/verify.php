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

<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/verify.css">
    <title>Verify</title>
</head>

<body>



    <body>
        <div class="container">
            <div class="card">
                <div class="profile-img">
                    <img src="profile-icon.jpg" alt="Profile Icon">
                </div>
                <h2>Forget Password</h2>
                <p>Enter email and contact number below to reset username and password</p>

                <form method="post" action="verify.php">
                    <div class="text-input">
                        <i class="ri-mail-fill"></i>
                        <input type="email" name="email" placeholder="Enter email" required>
                    </div><br>

                    <div class="text-input">
                        <i class="ri-phone-fill"></i>
                        <input type="number" name="number" placeholder="Enter contact number" required>
                    </div><br><br>

                    <button type="submit" class="btn verify-btn">Verify</button><br><br>
                    <a href="login.php" class="login-link">Login here</a>
                </form>

            </div>
        </div>


    </body>

</html>