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

if(!empty($start_date) && !empty($end_date)){
  $sql_sales = "SELECT * FROM invoices WHERE inv_date BETWEEN '$start_date' AND '$end_date'";
  $sql_sales_total = "SELECT SUM(net_total) AS net_total FROM invoices WHERE inv_date BETWEEN '$start_date' AND '$end_date'";
} else {
  $sql_sales_total = "SELECT SUM(net_total) AS net_total FROM invoices";
  $sql_sales = "SELECT * FROM invoices ORDER BY inv_number DESC";
}

$res_sales = mysqli_query($conn, $sql_sales);
$result_net_total = mysqli_query($conn, $sql_sales_total);
$row_net_total = mysqli_fetch_assoc($result_net_total);
$net_total = $row_net_total['net_total'];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sales Report</title>
    <link rel="stylesheet" href="css/Sales_Report.css">
  </head>
  <body>
    <div class="container">
      <div class="sales-report">
        <h1>Sales Report</h1>
        <table class="report-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Invoice Number</th>
              <th>Customer Name</th>
              <th>Sales Date</th>
              <th>Total Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php 
                while($row_sales = mysqli_fetch_assoc($res_sales)){
                ?>
                <tr>
                    <td><?php echo $row_sales['id']; ?></td>
                    <td><?php echo $row_sales['inv_number']; ?></td>
                    <td><?php echo $row_sales['customer_name']; ?></td>
                    <td><?php echo $row_sales['inv_date']; ?></td>
                    <td><?php echo $row_sales['net_total']; ?></td>
                </tr>
                <?php
              } ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="total-label">Total Sales = <?php echo $net_total ?></td>
              <td class="total-value"></td>
            </tr>
          </tfoot>
        </table>
        <div class="buttons">
          <button onclick="window.print()" class="save-button">Save</button>
          <button onclick="location.href='../dashboard/Sales report.php'" class="cancel-button">Cancel</button>
        </div>
      </div>
    </div>
  </body>
</html>
