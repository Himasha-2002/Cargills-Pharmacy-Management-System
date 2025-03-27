<?php
//database connection
include('../db_connect.php');

//register a user
if (isset($_POST['submit'])) {
    $pharmacy_name = $_POST['pharmacy_name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    //check email already exist
    $check_email_sql = "SELECT * FROM users WHERE email = '$email'";
    $res_check_email = mysqli_query($conn, $check_email_sql);

    if (mysqli_num_rows($res_check_email) > 0) {
        echo '<script>alert("Email is already exist. Please enter a different email")</script>';
    } else {
        //check username already exist
        $check_username_sql = "SELECT * FROM users WHERE username = '$username'";
        $res_check_username = mysqli_query($conn, $check_username_sql);

        if (mysqli_num_rows($res_check_username) > 0) {
            echo '<script>alert("Username is already exist. Please enter a different username")</script>';
        } else {
            //check password and confirm password match
            if($password === $confirm_password){
                //create a user
                $sql = "INSERT INTO users(pharmacy_name, address, email, contact, username, password, confirm_password) VALUES('$pharmacy_name', '$address', '$email', '$number', '$username', '$password', '$confirm_password')";
                $result = mysqli_query($conn, $sql);

                if($result){
                    header("Location:login.php");
                    exit();
                } else{
                    echo '<script>alert("Something went wrong.")</script>';
                }
            } else{
                echo '<script>alert("Password does not match! Try again.")</script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/register.css">
    <title>Pharmacy Management Setup</title>
</head>

<body>

    <div class="container">
        <h1>Pharmacy Management<br>One Time Setup</h1>
        <p>Enter Necessary Pharmacy Details</p><br>
        <form method="post" action="">
            <div class="text-input">
                <i class="ri-hospital-fill"></i>
                <input type="text" placeholder="Pharmacy Name" name="pharmacy_name" required>
            </div><br>

            <div class="text-input">
                <i class="ri-map-pin-2-fill"></i>
                <input type="text" placeholder="Address" name="address" required>
            </div><br>

            <div class="text-input">
                <i class="ri-mail-fill"></i>
                <input type="email" placeholder="Email" name="email" required>
            </div><br>

            <div class="text-input">
                <i class="ri-phone-fill"></i>
                <input type="tel" placeholder="Contact Number" name="number" pattern="[0-9]{10}" required>
            </div><br>

            <div class="text-input">
                <i class="ri-user-fill"></i>
                <input type="text" placeholder="Enter Username" name="username" required>
            </div><br>

            <div class="text-input">
                <i class="ri-lock-fill"></i>
                <input type="password" placeholder="Enter New Password" name="password" required>
            </div><br>

            <div class="text-input">
                <i class="ri-lock-fill"></i>
                <input type="password" placeholder="Confirm Password" name="confirm_password" required>
            </div><br><br>

            <button type="submit" name="submit" class="btn">START</button><br><br>
            <span>Already have an account? <a style="color:white;" href="login.php">Login here</a> </span>
        </form>


    </div>
</body>

</html>