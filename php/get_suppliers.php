<?php
  require "db_connection.php";
  if($con) {
    $query = isset($_GET['query']) ? $_GET['query'] : '';
    $query = mysqli_real_escape_string($con, $query); // Prevent SQL injection
    $sql = "SELECT name FROM suppliers WHERE name LIKE '%$query%'";
    $result = mysqli_query($con, $sql);
    $suppliers = [];
    while($row = mysqli_fetch_assoc($result)) {
      $suppliers[] = $row;
    }
    echo json_encode($suppliers);
  }
?>