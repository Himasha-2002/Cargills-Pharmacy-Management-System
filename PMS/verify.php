
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
 
    <title>Verify</title>
 
    <?php
  session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_POST["email"]; // Get user email/phone

    // Generate 6-digit OTP
    $otp = rand(100000, 999999);
    echo "Generated OTP: " . $_SESSION['otp']; 


    // Store OTP in session or database
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $user_email;

    // Send OTP via email (example using mail function)
    $subject = "Your OTP Code";
    $message = "Your OTP is: " . $otp;
    $headers = "From: noreply@example.com";

    // Use mail() function (configure SMTP settings for actual use)
    mail($user_email, $subject, $message, $headers);

    // Redirect to otp_verification.php
    header("Location: otp_verification.php");
    exit();
    
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
    font-size: 24px;
    font-family:'Times New Roman', Times, serif;
    font-size: 30px;
}

p {
    font-size: 19px;
    font-size: 16px;
    margin-bottom: 20px;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
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