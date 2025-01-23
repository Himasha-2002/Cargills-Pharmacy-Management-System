
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <title>Pharmacy Management Setup</title>

    <?php
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($query) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $conn->error;
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
            background-color: #800000;
            color: white;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
            border: 2px solid #0f0e0e; 
          
        }

        .container h1 {
            font-size: 30px;
            margin-bottom: 10px;
            font-family:'Times New Roman', Times, serif;
        }

        .container p {
            font-size: 17px;
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
            background-color: white;
            color: #800000;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #ffcccc;
        }
    </style>

</head>   
 

<body>
   
    <div class="container">
        <h1>Pharmacy Management<br>One Time Setup</h1>
        <p>Enter Necessary Pharmacy Details</p><br>
        <form method="post" action="first.php">
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

    <a href="..\dashboard\Dashboard.html">  <button type="submit" class="btn">START</button ></a>
</form>

    
    </div>
</body>
</html>
