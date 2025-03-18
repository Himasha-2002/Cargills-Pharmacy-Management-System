<?php
  require "db_connection.php";
  if($con) {
    // Get form data
    $name = ucwords($_POST["name"]);
    $batch_id = strtoupper($_POST["batch_id"]);
    $expiry_date = $_POST["expiry_date"];
    $quantity = $_POST["quantity"];
    $mrp = $_POST["mrp"];
    $rate = $_POST["rate"];
    $packing = strtoupper($_POST["packing"]);
    $generic_name = ucwords($_POST["generic_name"]);
    $supplier_name = ucwords($_POST["supplier_name"]);

    // Check if the medicine with the same batch ID already exists in the stock table
    $query = "SELECT * FROM medicines_stock WHERE UPPER(NAME) = '".strtoupper($name)."' AND UPPER(BATCH_ID) = '".strtoupper($batch_id)."'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if($row) {
      echo "Medicine $name with batch ID $batch_id already exists in stock!";
    } else {
      // Check if the medicine already exists in the medicines table
      $query = "SELECT * FROM medicines WHERE UPPER(NAME) = '".strtoupper($name)."' AND UPPER(SUPPLIER_NAME) = '".strtoupper($supplier_name)."'";
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);

      if($row) {
        // Medicine exists in the medicines table, update it if necessary
        $query = "UPDATE medicines SET PACKING = '$packing', GENERIC_NAME = '$generic_name' WHERE NAME = '$name' AND SUPPLIER_NAME = '$supplier_name'";
        mysqli_query($con, $query);
      } else {
        // Medicine does not exist in the medicines table, insert a new entry
        $query = "INSERT INTO medicines (NAME, PACKING, GENERIC_NAME, SUPPLIER_NAME) VALUES('$name', '$packing', '$generic_name', '$supplier_name')";
        mysqli_query($con, $query);
      }

      // Insert new stock entry into the medicines_stock table
      $query = "INSERT INTO medicines_stock (NAME, BATCH_ID, EXPIRY_DATE, QUANTITY, MRP, RATE) VALUES('$name', '$batch_id', '$expiry_date', $quantity, $mrp, $rate)";
      $result = mysqli_query($con, $query);
      if(!empty($result))
        echo "$name (Batch: $batch_id) added to stock ";
      else
        echo "Failed to add $name (Batch: $batch_id) to stock!";
    }
  }
?>