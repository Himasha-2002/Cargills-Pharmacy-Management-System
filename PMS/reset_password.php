

<!DOCTYPE html>
<html lang="en">
<head>
    
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>Reset Password</title>
    
</head>

<?php
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $query = "UPDATE users SET password='$new_password' WHERE email='$email'";
    if ($conn->query($query) === TRUE) {
        echo "Password reset successful!";
    } else {
        echo "Error updating password!";
    }
}
?>

<style>
body {
    background: url('back11.jpg') no-repeat center center/cover;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0;
    padding: 0;
}

.container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    box-sizing: border-box;
}

.card {
    background-color: #800000;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border: 2px solid #0f0e0e; 
}

.profile-img img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: #ffffff;
    margin-bottom: 15px;
}

h2 {
    margin: 10px 0;
    font-size: 32px;
    font-family:'Times New Roman', Times, serif;
}

.text-input {
             background: #e6e6e6;
             height: 40px;
             display: flex;
             width: 90%;
             align-items: center;
             border-radius: 10px;
             padding: 0 15px;
             margin: 5px 0;
}

.text-input input {
    background: none;
    border: none;
    outline: none;
    width: 100%;
    height: 100%;
    margin-left: 10px;
}
.text-input i {
    color: #686868;
}

::placeholder {
    color: #9a9a9a;
}

.btn {
    display: inline-block;
    width: 100%;
    background-color: #ffffff;
    color: #800000;
    border: none;
    border-radius: 5px;
    padding: 10px;
    font-size: 16px;
    cursor: pointer;
    text-transform: uppercase;
    font-weight: bold;
}

.btn:hover {
    background-color: #ffe6e6;
}

.login-link {
    display: block;
    margin-top: 15px;
    font-size: 14px;
    color: #ffffff;
    text-decoration: none;
}

.login-link:hover {
    text-decoration: underline;
}


</style>
<body>
    <div class="container">
        <div class="card"><br>
            <div class="profile-img">
                <img src="profile-icon.jpg"Profile Icon>
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
