<?php
session_start();

//database connection
include('../db_connect.php');

//login a user
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //check account is available
    $check_email_sql = "SELECT * FROM users WHERE email = '$email'";
    $res_check_email = mysqli_query($conn, $check_email_sql);

    if (mysqli_num_rows($res_check_email) > 0) {
        $user = mysqli_fetch_assoc($res_check_email);
        $login_password = $user['password'];

        if ($password === $login_password) {
            $_SESSION['user_email'] = $email;
            header("Location:../dashboard/Dashboard.php");
            exit();
        } else{
            echo '<script>alert("Password is incorrect.")</script>';
        }
    } else {
        echo '<script>alert("Can not find account. Please register before login.")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cargills Pharmacy Login</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="container">
        <div class="card"><br>
            <div class="profile-img">
                <img src="profile-icon.jpg" alt="Profile Icon">
            </div>
            <h2>Cargills Pharmacy Login</h2><br>
            <form method="post" action="login.php">
                <div class="text-input">
                    <i class="ri-user-fill"></i>
                    <input type="username" name="email" placeholder="Enter Email" required>
                </div><br>
                <div class="text-input">
                    <i class="ri-lock-fill"></i>
                    <input type="password" name="password" placeholder="Enter Password" required>
                </div><br><br>
                <button type="submit" name="submit" class="btn login-btn">Login</button><br><br>
                <a href="verify.php" class="forgot-link">Forgot Password?</a><br>
                <span>Don't have an account? <a class="forgot-link" href="register.php">Register here</a></span>
            </form>
        </div>
    </div>
</body>

</html>