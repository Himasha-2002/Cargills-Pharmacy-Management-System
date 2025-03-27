<?php
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
  header("location:../PMS/login.php");
  exit();
}

//database connection
include('../db_connect.php');

//GET start and end date
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : "";
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : "";

if (!empty($start_date) && !empty($end_date)) {
  $sql_purchases = "SELECT * FROM purchases WHERE date BETWEEN '$start_date' AND '$end_date'";
  $sql_purchases_total = "SELECT SUM(grand_total) AS grand_total FROM purchases WHERE date BETWEEN '$start_date' AND '$end_date'";
} else {
  $sql_purchases_total = "SELECT SUM(grand_total) AS grand_total FROM purchases";
  $sql_purchases = "SELECT * FROM purchases ORDER BY inv_number DESC";
}

$res_purchases = mysqli_query($conn, $sql_purchases);
$result_grand_total = mysqli_query($conn, $sql_purchases_total);
$row_grand_total = mysqli_fetch_assoc($result_grand_total);
$grand_total = $row_grand_total['grand_total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Purchase Report</title>
  <link rel="stylesheet" href="assest/purchersReport.css">
</head>

<body>
  <div class="container">
    <div class="report-section">
      <h2>Purchase Report Between ( Date )</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Invoice No:</th>
            <th>Supplier Name</th>
            <th>Purchase Date</th>
            <th>Payment Type</th>
            <th>Total Amount</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row_purchases = mysqli_fetch_assoc($res_purchases)) {
            ?>
            <tr>
              <td><?php echo $row_purchases['id']; ?></td>
              <td><?php echo $row_purchases['inv_number']; ?></td>
              <td><?php echo $row_purchases['supplier']; ?></td>
              <td><?php echo $row_purchases['date']; ?></td>
              <td><?php echo $row_purchases['payment_type']; ?></td>
              <td><?php echo $row_purchases['grand_total']; ?></td>
            </tr>
            <?php
          } ?>
        </tbody>
      </table>
      <div class="buttons">
        <button onclick="window.print()" type="submit" class="save-btn">Save</button>
        <button onclick="location.href='../dashboard/Sales report.php'" type="button" class="cancel-btn">Cancel</button>
      </div>
    </div>
  </div>
</body>

</html>