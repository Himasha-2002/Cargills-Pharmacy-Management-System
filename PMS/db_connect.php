<?php
// db_connect.php - Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "pharmacydb";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>