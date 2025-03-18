<?php
// Include the database connection file
require "db_connection.php";

// Function to delete an invoice
if (isset($_GET["action"]) && $_GET["action"] == "delete") {
  $invoice_number = $_GET["invoice_number"];
  $query = "DELETE FROM invoices WHERE INVOICE_ID = $invoice_number";
  $result = mysqli_query($con, $query);
  if ($result) {
    showInvoices();
  } else {
    echo "Error: " . mysqli_error($con);
  }
}

// Function to refresh the invoice list
if (isset($_GET["action"]) && $_GET["action"] == "refresh") {
  showInvoices();
}

// Function to search invoices
if (isset($_GET["action"]) && $_GET["action"] == "search") {
  searchInvoice(strtoupper($_GET["text"]), $_GET["tag"]);
}

// Function to display all invoices
function showInvoices() {
  global $con; // Use the global connection variable
  if ($con) {
    $seq_no = 0;
    $query = "SELECT * FROM invoices INNER JOIN customers ON invoices.CUSTOMER_ID = customers.ID";
    $result = mysqli_query($con, $query);
    if ($result) {
      while ($row = mysqli_fetch_array($result)) {
        $seq_no++;
        showInvoiceRow($seq_no, $row);
      }
    } else {
      echo "Error: " . mysqli_error($con); // Debug any query errors
    }
  } else {
    echo "Database connection is null!";
  }
}

// Function to display a single invoice row
function showInvoiceRow($seq_no, $row) {
  ?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo $row['INVOICE_ID']; ?></td>
    <td><?php echo $row['NAME']; ?></td>
    <td><?php echo $row['INVOICE_DATE']; ?></td>
    <td><?php echo $row['TOTAL_AMOUNT']; ?></td>
    <td><?php echo $row['TOTAL_DISCOUNT']; ?></td>
    <td><?php echo $row['NET_TOTAL']; ?></td>
    <td>
      <button class="btn btn-warning btn-sm fa fa-print" onclick="window.location.href='php/print_invoice.php?invoice_number=<?php echo $row['INVOICE_ID']; ?>';"></button>
        
      </button>
      <button class="btn btn-danger btn-sm" onclick="deleteInvoice(<?php echo $row['INVOICE_ID']; ?>);">
        <i class="fa fa-trash"></i>
      </button>
    </td>
  </tr>
  <?php
}

// Function to search invoices
function searchInvoice($text, $column) {
  global $con; // Use the global connection variable
  if ($con) {
    $seq_no = 0;
    if ($column == 'INVOICE_ID') {
      $query = "SELECT * FROM invoices INNER JOIN customers ON invoices.CUSTOMER_ID = customers.ID WHERE CAST(invoices.$column AS VARCHAR(9)) LIKE '%$text%'";
    } else if ($column == "INVOICE_DATE") {
      $query = "SELECT * FROM invoices INNER JOIN customers ON invoices.CUSTOMER_ID = customers.ID WHERE invoices.$column = '$text'";
    } else {
      $query = "SELECT * FROM invoices INNER JOIN customers ON invoices.CUSTOMER_ID = customers.ID WHERE UPPER(customers.$column) LIKE '%$text%'";
    }

    $result = mysqli_query($con, $query);
    if ($result) {
      while ($row = mysqli_fetch_array($result)) {
        $seq_no++;
        showInvoiceRow($seq_no, $row);
      }
    } else {
      echo "Error: " . mysqli_error($con); // Debug any query errors
    }
  } else {
    echo "Database connection is null!";
  }
}
?>