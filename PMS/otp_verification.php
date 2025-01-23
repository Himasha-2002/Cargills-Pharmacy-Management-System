
<!DOCTYPE html>
<html lang="en">
<head>
    <title>OTP Verification</title>
</head>

<style>
body {
    background: url('back11.jpg') no-repeat center center/cover;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}


.container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    box-sizing: border-box;
}


.card {
    background-color: #800000;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    border: 2px solid #0f0e0e;
}


h2 {
    margin: 10px 0;
    font-size: 28px;
    font-weight: bold;
}


.otp-input {
    background: #e6e6e6;
    height: 45px;
    display: flex;
    width: 90%;
    align-items: center;
    border-radius: 10px;
    padding: 0 15px;
    margin: 8px auto;
    border: 1px solid #ccc;
    font-size: 16px;
    text-align: center;
    letter-spacing: 5px;
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

::placeholder {
    color: #9a9a9a
}
</style>
<body>
<div class="container">
    <div class="card">
        <h2>OTP Verification</h2>
        <p>Enter the OTP sent to your email</p>

        <form method="post">
            <input type="text" name="otp" class="otp-input" placeholder="Enter OTP" required>
            <button type="submit" class="btn">Verify OTP</button>
        </form>

        <?php if (isset($_SESSION['error'])) { 
            echo "<p class='error-message'>".$_SESSION['error']."</p>"; 
            unset($_SESSION['error']); 
        } ?>
    </div>
</div>
    </body>
    </html>


