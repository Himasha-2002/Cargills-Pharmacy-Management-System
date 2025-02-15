
<!DOCTYPE html>
<html lang="en">
<head>
  
    <title>Cargills Pharmacy Login</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<?php
session_start(); 
include 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']); 
    $password = trim($_POST['password']); 

    // Check if the user exists
    $stmt = $conn->prepare("SELECT * FROM admin_credentials WHERE USERNAME = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verify user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Use the correct column names (uppercase)
        if (password_verify($password, $row['PASSWORD'])) { // ✅ Check if password matches
            $_SESSION['USERNAME'] = $row['USERNAME']; // ✅ Store only username
            echo "<script>alert('Login successful!'); window.location.href='dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid password!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
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
    font-size: 30px;
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

.forgot-link {
    display: block;
    margin-top: 15px;
    font-size: 14px;
    color: #ffffff;
    text-decoration: none;
}

.forgot-link:hover {
    text-decoration: underline;
}

</style>

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
                <input type="username" name="username" placeholder="Enter Username" required>
             </div><br>
            <div class="text-input">
                <i class="ri-lock-fill"></i>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div><br><br>
            <button type="submit" class="btn login-btn">Login</button><br><br>
            <a href="verify.php" class="forgot-link">Forgot Password?</a>
        </form>
        </div>
    </div>
</body>
</html>