<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Manage Invoices</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/home.css">
    <script src="js/manage_invoice.js"></script>
  </head>
  <body>
    <!-- including side navigations -->
    <?php include("sections/sidenav.html"); ?>

    <div class="container-fluid">
      <div class="container">

        <!-- header section -->
        <?php
          require "php/header.php";
          createHeader('clipboard', 'Manage Invoices', 'Manage Existing Invoices');
        ?>
        <!-- header section end -->

        <!-- form content -->
        <div class="row">
          <div class="col col-md-12">
            <hr class="col-md-12" style="padding: 0px; border-top: 3px solid  #02b6ff;">
          </div>

          <!-- search and add new invoice button -->
          <div class="row col col-md-12">
            <div class="col col-md-2 form-group">
              <label class="font-weight-bold" for="search_by">Search By :</label>
              <select id="search_by" class="form-control">
                <option value="INVOICE_ID">Invoice ID</option>
                <option value="NAME">Customer Name</option>
                <option value="INVOICE_DATE">Invoice Date</option>
              </select>
            </div>
            <div class="col col-md-3 form-group">
              <label class="font-weight-bold" for="search_text">Search Text :</label>
              <input id="search_text" type="text" class="form-control" placeholder="Search Text" onkeyup="searchInvoice(this.value, document.getElementById('search_by').value);">
            </div>
            <div class="col col-md-2 form-group">
              <label class="font-weight-bold" for=""></label>
              <button class="btn btn-primary form-control" onclick="refreshInvoices();">Refresh</button>
            </div>
          </div>
          <!-- search and add new invoice button end -->

          <div class="col col-md-12">
            <hr class="col-md-12" style="padding: 0px; border-top: 2px solid  #02b6ff;">
          </div>

          <!-- invoices table -->
          <div class="row col col-md-12">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Invoice ID</th>
                  <th>Customer Name</th>
                  <th>Invoice Date</th>
                  <th>Total Amount</th>
                  <th>Total Discount</th>
                  <th>Net Total</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="invoices_div">
                <?php
                  require "php/manage_invoice.php";
                  if (isset($_GET['action']) && $_GET['action'] == 'refresh') {
                    showInvoices();
                  } else {
                    showInvoices();
                  }
                ?>
              </tbody>
            </table>
          </div>
          <!-- invoices table end -->

        </div>
        <!-- form content end -->
        <hr style="border-top: 2px solid #ff5252;">
      </div>
    </div>
  </body>
</html>