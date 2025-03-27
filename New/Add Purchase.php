<?php
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
  header("location:../PMS/login.php");
  exit();
}

//database connection
include('../db_connect.php');

//retrieve all suppliers
$sql_supplier = "SELECT * FROM supplier";
$res_supplier = mysqli_query($conn, $sql_supplier);

//retrieve all medicine
$sql_medicine = "SELECT * FROM medicine";
$res_medicine = mysqli_query($conn, $sql_medicine);

//retrieve all medicine_stock
$sql_medicine_stock = "SELECT medicine.medicine_name , medicine_stock.packing, medicine_stock.batch_id, medicine_stock.expire_date, medicine_stock.quantity, medicine_stock.mrp, medicine_stock.rate, medicine_stock.amount FROM medicine LEFT JOIN medicine_stock ON medicine.medicine_name = medicine_stock.medicine_name";
$res_medicine_stock = mysqli_query($conn, $sql_medicine_stock);

$date = date("Y-m-d");

//auto generated invoice number
$sql_invoice = "SELECT inv_number FROM purchases ORDER BY inv_number DESC LIMIT 1";
$res_invoice = mysqli_query($conn, $sql_invoice);

if (mysqli_num_rows($res_invoice) > 0) {
  $row_invoice = $res_invoice->fetch_assoc();
  $last_id = $row_invoice['inv_number'];
  $num = (int) substr($last_id, 2);
  $inv_number = 'P-' . str_pad($num + 1, 5, '0', STR_PAD_LEFT);
} else {
  $inv_number = 'P-00001';
}

//add a purchase and medicine stock
if (isset($_POST['submit'])) {
  $supplier = $_POST['supplier'];
  $payment = $_POST['payment'];
  $inv_number = $_POST['inv_number'];
  $date = $_POST['date'];
  $total = $_POST['total'];

  $sql_purchase = "INSERT INTO purchases(inv_number, supplier, payment_type, date, grand_total) VALUES('$inv_number', '$supplier', '$payment', '$date', '$total')";
  $res_purchase = mysqli_query($conn, $sql_purchase);

  if ($res_purchase) {
    $medicine_names = $_POST['medicine_name'];
    $batch_ids = $_POST['batch_id'];
    $packings = $_POST['packing'];
    $quantities = $_POST['quantity'];
    $expire_dates = $_POST['expire_date'];
    $rates = $_POST['rate'];
    $mrps = $_POST['mrp'];
    $amounts = $_POST['amount'];

    for ($i = 0; $i < count($medicine_names); $i++) {
      $medicine_name = $medicine_names[$i];
      $batch_id = strtoupper($batch_ids[$i]);
      $packing = $packings[$i];
      $quantity = $quantities[$i];
      $expire_date = $expire_dates[$i];
      $rate = $rates[$i];
      $mrp = $mrps[$i];
      $amount = $amounts[$i];

      //check medicine name already exist
      $sql_check_med_name = "SELECT medicine_name FROM medicine_stock WHERE medicine_name = '$medicine_name'";
      $res_check_med_name = mysqli_query($conn, $sql_check_med_name);

      if (mysqli_num_rows($res_check_med_name) > 0) {
        $update_sql = "UPDATE medicine_stock SET medicine_name = '$medicine_name', packing = '$packing', batch_id = '$batch_id', expire_date = '$expire_date', quantity = '$quantity', mrp = '$mrp', rate = '$rate', amount = '$amount' WHERE medicine_name = '$medicine_name'";
        $res_update = mysqli_query($conn, $update_sql);

        if ($res_update) {
          echo '<script>alert("Purchase added successfully.")</script>';
        } else {
          echo '<script>alert("Something went wrong.")</script>';
        }
      } else {
        $insert_sql = "INSERT INTO medicine_stock(medicine_name, packing, batch_id, expire_date, quantity, mrp, rate, amount) VALUES('$medicine_name', '$packing', '$batch_id', '$expire_date', '$quantity', '$mrp', '$rate', '$amount')";
        $res_insert = mysqli_query($conn, $insert_sql);

        if ($res_insert) {
          echo '<script>alert("Purchase added successfully.")</script>';
        } else {
          echo '<script>alert("Something went wrong.")</script>';
        }
      }
    }
  } else {
    echo '<script>alert("Something went wrong.")</script>';
  }

}

//close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add purchase</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/Add-Purchase.css">
</head>

<body>
  <div class="sidebar">
    <div class="profile">
      <br><img src="Admin.jpg" alt="Admin">
      <h3>ADMIN</h3>
    </div>
    <div class="menu">
      <a href="..\dashboard\Dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a> <br>
      <div class="dropdown">
        <a href="#"><i class="fa-solid fa-file-invoice"></i> Invoice<span class="toggle">
            < </span></a>
        <div class="dropdown-content">
          <a href="..\Cargils\New Invoice.php">New Invoice</a>
          <a href="..\dashboard\Manage Invoice.php">Manage Invoice</a>
        </div>
      </div>
      <div class="dropdown">
        <a href="#"><i class="fa-solid fa-users"></i> Customer<span class="toggle">
            < </span></a>
        <div class="dropdown-content">
          <a href="..\New\Add Customer.php">Add Customer</a>
          <a href="..\Naduni\Manage Customer.php">Manage Customer</a>
        </div>
      </div>
      <div class="dropdown">
        <a href="#"><i class="fa-solid fa-capsules"></i> Medicine<span class="toggle">
            < </span></a>
        <div class="dropdown-content">
          <a href="..\Medicine\Add_Medicine.php">Add Medicine</a>
          <a href="..\Medicine\Manage_medicine.php">Manage Medicine</a>
          <a href="..\Medicine\Manage_medicine_Stock.php">Manage Medicine Stock</a>
        </div>
      </div>
      <div class="dropdown">
        <a href="#"><i class="fas fa-truck"></i> Supplier<span class="toggle">
            < </span></a>
        <div class="dropdown-content">
          <a href="..\Cargils\Add Supplier.php">Add Supplier</a>
          <a href="..\Cargils\Manage Supplier.php">Manage Supplier</a>
        </div>
      </div>
      <div class="dropdown">
        <a href="#"><i class="fa-solid fa-cart-shopping"></i> Purchase<span class="toggle">
            < </span></a>
        <div class="dropdown-content">
          <a href="..\New\Add Purchase.php">Add Purchase</a>
          <a href="..\New\Manage Purchase.php">Manage Purchase</a>
        </div>
      </div>
      <div class="dropdown">
        <a href="#"><i class="fas fa-chart-bar"></i> Report<span class="toggle">
            < </span></a>
        <div class="dropdown-content">
          <a href="..\dashboard\Sales report.php">Sales Report</a>
          <a href="..\New\Purchase Report.php">Purchase Report</a>
        </div>
      </div>
    </div>

  </div>
  <div class="main-content">
    <div class="header">

      <div>
        <h1><i class="fa-solid fa-cart-shopping"></i>Add Purchase</h1>
        <p>Add New Purchase</p>
      </div>
      <div class="settings-dropdown">
        <a href="#"><i class="fas fa-cog settings-icon"></i></a>
        <div class="settings-menu">
          <a href="..\Naduni\Profile.php"><i class="fas fa-user"></i>My Profile</a>
          <a href="..\Cargils\Password.php"><i class="fas fa-key"></i>Change Password</a>
          <a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
      </div>
    </div>
    <section class="purchase-form">
      <form action="" method="post">
        <div class="form-header">
          <div>
            <label for="supplier">Supplier:</label>
            <select name="supplier" id="supplier">
              <option value="">Select a supplier</option>
              <?php
              while ($row_supplier = mysqli_fetch_assoc($res_supplier)) {
                ?>
                <option value="<?php echo $row_supplier['name']; ?>"><?php echo $row_supplier['name']; ?></option>
                <?php
              }
              ?>
            </select><br><br><br>
            <div style="display:flex; width:100%; gap:10px;">
              <button type="button" style="padding: 10px 4px;" class="add-supplier" onclick="window.location.href='../Cargils/Add Supplier.php'">+ Add New Supplier</button>

              <button type="button" style="padding: 10px 4px;" class="add-supplier" onclick="window.location.href='../Medicine/Add_Medicine.php'">+ Add New Medicine</button>
          </div>
          </div>
          <div>
            <label for="payment-type">Payment Type:</label>
            <select id="payment" name="payment" >
              <option value="Cash Payment">Cash Payment</option>
              <option value="Card Payment">Card Payment</option>
            </select>
          </div>
          <div>
            <label for="invoice-number">Invoice Number:</label>
            <input type="text" name="inv_number" id="invoice-number" value="<?php echo $inv_number ?>" readonly
              >
          </div>
          <div>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo $date ?>" readonly >
          </div>
        </div>

        <!-- Table for Medicine -->
        <table>
          <thead>
            <tr>
              <th>Medicine Name</th>
              <th>Packing</th>
              <th>Batch ID</th>
              <th>Ex Date (mm/yy)</th>
              <th>MRP</th>
              <th>Rate</th>
              <th>Quantity</th>
              <th>Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <select name="medicine_name[]" class="medicine" >
                  <option value="" selected>Select a medicine</option>
                  <?php
                  while ($row_medicine = mysqli_fetch_assoc($res_medicine_stock)) {
                    ?>
                    <option value="<?php echo $row_medicine['medicine_name']; ?>"
                      data-packing="<?php echo $row_medicine['packing']; ?>"
                      data-batch="<?php echo $row_medicine['batch_id']; ?>"
                      data-expire="<?php echo $row_medicine['expire_date']; ?>"
                      data-mrp="<?php echo $row_medicine['mrp']; ?>" 
                      data-rate="<?php echo $row_medicine['rate']; ?>"
                      data-quantity="<?php echo $row_medicine['quantity']; ?>">
                      <?php echo $row_medicine['medicine_name']; ?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </td>
              <td><input type="text" name="packing[]" class="packing" ></td>
              <td><input type="text" name="batch_id[]" class="batch_id" ></td>
              <td><input type="month" name="expire_date[]" class="expire_date" ></td>
              <td><input type="text" name="mrp[]" class="mrp" ></td>
              <td><input type="number" name="rate[]" class="rate" ></td>
              <td><input type="number" name="quantity[]" class="quantity" ></td>
              <td><input type="text" name="amount[]" class="amount"  readonly></td>
              <td>
                <button type="button" class="add-row"><i class="fas fa-plus"></i></button>
                <button type="button" class="delete-row"><i class="fas fa-trash"></i></button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Grand Total -->
        <div class="grand-total">
          <span><b>Grand Total:</b></span>
          <input type="text" name="total" readonly>
        </div>

        <button name="submit" class="add-button">ADD</button>
      </form>
    </section>
    </main>
  </div>
  <script>
    // JavaScript to handle dropdown functionality
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(dropdown => {
      const toggle = dropdown.querySelector('.toggle');
      const content = dropdown.querySelector('.dropdown-content');

      toggle.addEventListener('click', () => {
        const isVisible = content.style.display === 'flex';
        content.style.display = isVisible ? 'none' : 'flex';
        toggle.textContent = isVisible ? '<' : 'v'; // Toggle symbol
      });
    });

    // JavaScript to handle settings dropdown functionality

    const settingsIcon = document.querySelector('.settings-icon');
    const settingsMenu = document.querySelector('.settings-menu');

    settingsIcon.addEventListener('click', (e) => {
      e.preventDefault();
      const isVisible = settingsMenu.style.display === 'block';
      settingsMenu.style.display = isVisible ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
      if (!e.target.closest('.settings-dropdown')) {
        settingsMenu.style.display = 'none';
      }
    });

    //auto fill & calculate amount
    document.addEventListener("DOMContentLoaded", function () {
      function updateGrandTotal() {
        let total = 0;
        document.querySelectorAll(".amount").forEach(amountField => {
          total += parseFloat(amountField.value) || 0;
        });
        document.querySelector("input[name='total']").value = total.toFixed(2);
      }

      // Update Amount when Quantity changes
      document.addEventListener("input", function (event) {
        if (event.target.classList.contains("quantity")) {
          let row = event.target.closest("tr");
          let rate = parseFloat(row.querySelector(".rate").value) || 0;
          let quantity = parseInt(event.target.value) || 0;
          let amountField = row.querySelector(".amount");

          amountField.value = (rate * quantity).toFixed(2);
          updateGrandTotal();
        }
      });

      // Update Grand Total
      document.addEventListener("click", function (event) {
        let tableBody = document.querySelector("tbody");

        if (event.target.closest(".add-row")) {
          let lastRow = tableBody.querySelector("tr:last-child");
          let newRow = lastRow.cloneNode(true);

          newRow.querySelectorAll("input").forEach(input => {
            input.value = "";
          });

          tableBody.appendChild(newRow);
          updateGrandTotal();
        }

        if (event.target.closest(".delete-row")) {
          let rowToDelete = event.target.closest("tr");
          if (tableBody.rows.length > 1) {
            rowToDelete.remove();
            updateGrandTotal();
          } else {
            alert("You must have at least one row.");
          }
        }
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("change", function (event) {
        if (event.target.classList.contains("medicine")) {
            let selectedOption = event.target.options[event.target.selectedIndex];

            let row = event.target.closest("tr");
            row.querySelector(".packing").value = selectedOption.getAttribute("data-packing") || "";
            row.querySelector(".batch_id").value = selectedOption.getAttribute("data-batch") || "";
            row.querySelector(".expire_date").value = selectedOption.getAttribute("data-expire") || "";
            row.querySelector(".mrp").value = selectedOption.getAttribute("data-mrp") || "";
            row.querySelector(".rate").value = selectedOption.getAttribute("data-rate") || "";
            row.querySelector(".quantity").value = selectedOption.getAttribute("data-quantity") || "";
        }
    });
});

  </script>
</body>

</html>