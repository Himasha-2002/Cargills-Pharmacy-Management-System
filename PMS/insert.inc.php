<?php
require_once "config.php";

if ($_SERVER ["REQUEST_METHOD"] == "POSt"){
    $username = $_POST["name"];
    $password = $_POST["password"];

    $sql = "INSERT INTO user details (USERNAME , PASSWORD)
    VALUES('$name','$password')";

    if($connection->query($sql) === TRUE){
        echo"<script>alert('Data AddedSuccessfully')</script>";
        echo "<script> window.location.href='Display.php'";
    }else{
        echo "Error : " .sql . "<br>" .$conn->error;
    }
    }

$conne->close();


?>