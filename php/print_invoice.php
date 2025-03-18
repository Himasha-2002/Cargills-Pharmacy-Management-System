<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print Invoice</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    :root {
      --primary-color: #4361ee;
      --secondary-color: #3f37c9;
      --accent-color: #4895ef;
      --text-color: #333;
      --light-bg: #f8f9fa;
      --border-radius: 8px;
      --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f2f5;
      color: var(--text-color);
      line-height: 1.6;
      padding-bottom: 50px;
    }

    .invoice-container {
      background-color: white;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      padding: 2rem;
      margin: 2rem auto;
      max-width: 800px;
    }

    .invoice-header {
      border-bottom: 2px solid var(--light-bg);
      padding-bottom: 1.5rem;
      margin-bottom: 2rem;
    }

    .invoice-title {
      color: var(--primary-color);
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .invoice-number {
      font-size: 1.2rem;
      color: var(--secondary-color);
    }

    .invoice-date {
      color: #666;
    }

    .customer-details {
      background-color: var(--light-bg);
      border-radius: var(--border-radius);
      padding: 1.5rem;
      margin-bottom: 2rem;
    }

    .customer-details h4 {
      color: var(--primary-color);
      margin-bottom: 1rem;
      font-size: 1.2rem;
      font-weight: 600;
    }

    .customer-details p {
      margin-bottom: 0.5rem;
    }

    .table {
      margin-bottom: 2rem;
    }

    .table thead th {
      background-color: var(--light-bg);
      color: var(--primary-color);
      border-top: none;
      font-weight: 600;
    }

    .table tbody tr:nth-child(even) {
      background-color: rgba(240, 242, 245, 0.5);
    }

    .table th, .table td {
      padding: 0.75rem;
      vertical-align: middle;
    }

    .total-section {
      background-color: var(--light-bg);
      border-radius: var(--border-radius);
      padding: 1.5rem;
      margin-bottom: 2rem;
    }

    .total-section p {
      margin-bottom: 0.5rem;
      text-align: right;
    }

    .total-section .net-total {
      font-size: 1.2rem;
      font-weight: 600;
      color: var(--primary-color);
    }

    .btn-print {
      background-color: var(--primary-color);
      color: white;
      border: none;
      border-radius: 50px;
      padding: 0.5rem 2rem;
      font-weight: 600;
      transition: all 0.3s ease;
      margin-right: 10px;
    }

    .btn-back {
      background-color: #6c757d;
      color: white;
      border: none;
      border-radius: 50px;
      padding: 0.5rem 2rem;
      font-weight: 600;
      transition: all 0.3s ease;
      margin-left: 10px;
    }

    .btn-print:hover, .btn-back:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-print:hover {
      background-color: var(--secondary-color);
    }

    .btn-back:hover {
      background-color: #5a6268;
    }

    .btn-print i, .btn-back i {
      margin-right: 0.5rem;
    }

    .button-container {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
    }

    @media print {
      .no-print {
        display: none !important;
      }
      body {
        background-color: white;
        padding: 0;
        margin: 0;
      }
      .invoice-container {
        box-shadow: none;
        margin: 0;
        padding: 1rem;
        max-width: 100%;
      }
    }
  </style>
</head>
<body>
  <?php
  // Include the database connection file
  require "db_connection.php";

  if (isset($_GET["invoice_number"])) {
    $invoice_number = $_GET["invoice_number"];

    // Fetch invoice details
    $query = "SELECT * FROM invoices INNER JOIN customers ON invoices.CUSTOMER_ID = customers.ID WHERE invoices.INVOICE_ID = $invoice_number";
    $result = mysqli_query($con, $query);
    if ($result) {
      $row = mysqli_fetch_array($result);
      $customer_name = $row['NAME'];
      $address = $row['ADDRESS'];
      $contact_number = $row['CONTACT_NUMBER'];
      $invoice_date = $row['INVOICE_DATE'];
      $total_amount = $row['TOTAL_AMOUNT'];
      $total_discount = $row['TOTAL_DISCOUNT'];
      $net_total = $row['NET_TOTAL'];
    } else {
      echo "Error fetching invoice details: " . mysqli_error($con);
      exit;
    }
  } else {
    echo "Invoice number not provided!";
    exit;
  }
  ?>

  <div class="container">
    <div class="invoice-container">
      <div class="invoice-header text-center">
        <h2 class="invoice-title">CUSTOMER INVOICE</h2>
        <div class="invoice-number">Invoice #<?php echo $invoice_number; ?></div>
        <div class="invoice-date">Date: <?php echo date('F d, Y', strtotime($invoice_date)); ?></div>
      </div>

      <div class="customer-details">
        <h4><i class="fas fa-user"></i> Customer Details</h4>
        <p><strong>Name:</strong> <?php echo $customer_name; ?></p>
        <p><strong>Address:</strong> <?php echo $address; ?></p>
        <p><strong>Contact Number:</strong> <?php echo $contact_number; ?></p>
      </div>

      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>SL</th>
              <th>Description</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Discount</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Medicine/Service</td>
              <td>1</td>
              <td><?php echo number_format($total_amount, 2); ?></td>
              <td><?php echo $total_discount; ?>%</td>
              <td><?php echo number_format($net_total, 2); ?></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="total-section">
        <p><strong>Total Amount:</strong> <?php echo number_format($total_amount, 2); ?></p>
        <p><strong>Total Discount:</strong> <?php echo $total_discount; ?>%</p>
        <p class="net-total"><strong>Net Total:</strong> <?php echo number_format($net_total, 2); ?></p>
      </div>

      <div class="button-container no-print">
        <button onclick="window.print()" class="btn btn-print">
          <i class="fas fa-print"></i> Print Invoice
        </button>
        <button onclick="window.history.back()" class="btn btn-back">
          <i class="fas fa-arrow-left"></i> Back
        </button>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      // Add any additional JavaScript if needed
    });
  </script>
</body>
</html>