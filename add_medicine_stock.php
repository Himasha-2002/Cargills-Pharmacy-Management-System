<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Add Medicine Stock</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/home.css">
    <script src="js/suggestions.js"></script>
    <script src="js/validateForm.js"></script>
    <script src="js/restrict.js"></script>
    <style>
      .suggestions {
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        position: absolute;
        background: white;
        z-index: 1000;
        width: 100%;
      }
      .suggestions div {
        padding: 5px;
        cursor: pointer;
      }
      .suggestions div:hover {
        background: #f0f0f0;
      }
    </style>
  </head>
  <body>
    <!-- including side navigations -->
    <?php include("sections/sidenav.html"); ?>

    <div class="container-fluid">
      <div class="container">

        <!-- header section -->
        <?php
          require "php/header.php";
          createHeader('shopping-bag', 'Add Medicine Stock', 'Add New Medicine Stock');
        ?>
        <!-- header section end -->

        <!-- form content -->
        <div class="row">
          <div class="row col col-md-6">
            <form class="form-horizontal" id="addStockForm" method="POST">
              <div class="form-group">
                <label class="control-label col-md-4">Medicine Name</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="name" placeholder="Medicine Name" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4">Batch ID</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="batch_id" placeholder="Batch ID" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4">Expiry Date</label>
                <div class="col-md-8">
                  <input type="date" class="form-control" name="expiry_date" placeholder="Expiry Date" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4">Quantity</label>
                <div class="col-md-8">
                  <input type="number" class="form-control" name="quantity" placeholder="Quantity" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4">MRP</label>
                <div class="col-md-8">
                  <input type="number" step="0.01" class="form-control" name="mrp" placeholder="MRP" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4">Rate</label>
                <div class="col-md-8">
                  <input type="number" step="0.01" class="form-control" name="rate" placeholder="Rate" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4">Packing</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="packing" placeholder="Packing" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4">Generic Name</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="generic_name" placeholder="Generic Name" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4">Supplier Name</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Supplier Name" required>
                  <div id="supplierSuggestions" class="suggestions"></div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">Add Stock</button>
                </div>
              </div>
            </form>
            <div id="message"></div>
          </div>
        </div>

        <hr style="border-top: 2px solid #ff5252;">
        <!-- form content end -->
      </div>
    </div>

    <script>
      // Fetch and display supplier suggestions based on user input
      document.getElementById('supplier_name').addEventListener('input', function() {
        let query = this.value;
        if (query.length > 0) {
          fetch(`php/get_suppliers.php?query=${query}`)
            .then(response => response.json())
            .then(data => {
              let suggestions = document.getElementById('supplierSuggestions');
              suggestions.innerHTML = '';
              data.forEach(supplier => {
                let div = document.createElement('div');
                div.textContent = supplier.name;
                div.addEventListener('click', function() {
                  document.getElementById('supplier_name').value = supplier.name;
                  suggestions.innerHTML = '';
                });
                suggestions.appendChild(div);
              });
            });
        } else {
          document.getElementById('supplierSuggestions').innerHTML = '';
        }
      });

      // Handle form submission with AJAX
      document.getElementById('addStockForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let formData = new FormData(this);
        fetch('php/add_medicine_stock.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(data => {
          document.getElementById('message').innerHTML = `<div class="alert alert-info">${data}</div>`;
        })
        .catch(error => {
          document.getElementById('message').innerHTML = `<div class="alert alert-danger">Failed to add stock. Please try again.</div>`;
        });
      });
    </script>
  </body>
</html>