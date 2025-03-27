<?php
session_start();
//check user logged in
if (!isset($_SESSION['user_email'])) {
  header("location:../PMS/login.php");
  exit();
}

//database connection
include('../db_connect.php');

$date = date("Y-m-d");

//retrieve all customers
$sql_customers = "SELECT * FROM customers";
$res_customers = mysqli_query($conn, $sql_customers);

//auto generated invoice number
$sql_check_invoice = "SELECT inv_number FROM invoices ORDER BY inv_number DESC LIMIT 1";
$res_check_invoice = mysqli_query($conn, $sql_check_invoice);

if (mysqli_num_rows($res_check_invoice) > 0) {
  $row_invoice = $res_check_invoice->fetch_assoc();
  $last_id = $row_invoice['inv_number'];
  $num = (int) substr($last_id, 2);
  $inv_number = 'I-' . str_pad($num + 1, 5, '0', STR_PAD_LEFT);
} else {
  $inv_number = 'I-00001';
}

//retrieve all data from medicine_stock
$sql_medicine_stock = "SELECT * FROM medicine_stock WHERE quantity > 0";
$res_medicine_stock = mysqli_query($conn, $sql_medicine_stock);

//create new invoice
if(isset($_POST['submit'])){
  $customer_name = $_POST['customers'];
  $invoice_number = $_POST['inv_number'];
  $inv_date = $_POST['inv_date'];
  $total_amount = $_POST['total_amount'];
  $total_discount = $_POST['total_discount'];
  $net_total = $_POST['net_total'];

  $sql_insert = "INSERT INTO invoices(inv_number, customer_name, inv_date, total_amount, total_discount, net_total) VALUES('$invoice_number', '$customer_name', '$inv_date', '$total_amount', '$total_discount', '$net_total')";
  $res_insert = mysqli_query($conn, $sql_insert);

  if($res_insert){
    echo '<script>alert("New Invoice Created.")</script>';
    header("location:New Invoice.php");
    exit();
  } else{
    echo '<script>alert("Something went wrong.")</script>';
  }
}

?>

<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Invoice</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/new-invoice.css">
</head>

<body>
  <!--sidebar-->
  <div class="sidebar">
    <div class="profile">
      <br><img src="admin.jpg" alt="Admin">
      <h3>ADMIN</h3>
    </div>
    <div class="menu">
      <a href="..\dashboard\Dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a>
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
  <!--sidebar Toggle button for smaller screen-->
  <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

  <div class="main-content">
    <!--header-->
    <div class="header">
      <div>
        <h1><i class="fa-solid fa-file-invoice"></i>New Invoice</h1>
        <p>Create New Invoice</p>
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
    <section class="invoice-form">
      <form action="" method="post">
      <div class="form-header">
        <div>
          <label for="customer">Customer Name:</label>
          <select required name="customers" id="customers">
            <option value="" selected disabled>Select a customer</option>
            <?php
            while ($row = mysqli_fetch_assoc($res_customers)) {
              ?>
              <option value="<?php echo $row['customer_name']; ?>" data-address="<?php echo $row['address']; ?>"
                data-contact="<?php echo $row['contact']; ?>">
                <?php echo $row['customer_name']; ?>
              </option>
              <?php
            } ?>
          </select><br><br>
          <button onclick="location.href='../New/Add Customer.php'" class="add-customer">+ Add New Customer</button>
        </div>
        <div>
          <label for="customer">Address:</label>
          <input type="text" required id="address" readonly placeholder="Address"><br><br><br><br>
        </div>
        <div>
          <label for="invoice-number">Invoice Number:</label>
          <input type="text" name="inv_number" required readonly value="<?php echo $inv_number ?>" id="invoice-number"><br><br><br><br>
        </div>
        <div>
          <label for="payment-type">Payment Type:</label>
          <select required id="payment" name="payment">
            <option value="Cash Payment">Cash Payment</option>
            <option value="Card Payment">Card Payment</option>
          </select> <br><br><br><br>
        </div>
        <div>
          <label for="date">Date:</label>
          <input required type="date" name="inv_date" readonly value="<?php echo $date ?>" id="date"><br><br><br><br>
        </div>
        <div>
          <label for="customer">Contact Number:</label>
          <input required type="text" id="contact-number" readonly placeholder="Contact Number"><br><br><br><br>
        </div>
      </div>

      <!-- Table for Medicine -->
      <table>
        <thead>
          <tr>
            <th>Medicine Name</th>
            <th>Batch ID</th>
            <th>Ava.Qty.</th>
            <th>Expiry</th>
            <th>MRP</th>
            <th>Quantity</th>
            <th>Discount</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <select required name="medicine[]" class="medicine">
                <option value="" selected disabled>Select a medicine</option>
                <?php
                while ($rows = mysqli_fetch_assoc($res_medicine_stock)) {
                  ?>
                  <option value="<?php echo $rows['medicine_name']; ?>" data-batch-id="<?php echo $rows['batch_id']; ?>"
                    data-quantity="<?php echo $rows['quantity']; ?>" data-expire="<?php echo $rows['expire_date']; ?>"
                    data-mrp="<?php echo $rows['mrp']; ?>">
                    <?php echo $rows['medicine_name']; ?>
                  </option>
                <?php
                }
                ?>
              </select>
            </td>
            <td><input required name="batch_id[]" class="batch_id" type="text"></td>
            <td><input required name="ava_quantity[]" class="quantity" type="number"></td>
            <td><input required name="expire_date[]" class="expire_date" type="text"></td>
            <td><input required name="mrp[]" class="mrp" type="text" min="0"></td>
            <td><input required name="quantity[]" type="number"></td>
            <td><input name="discount[]" type="number" min="0"></td>
            <td><input required name="total[]" type="number" readonly></td>
            <td>
              <button class="add-row"><i class="fas fa-plus"></i></button>
              <button class="delete-row"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Grand Total -->

      <div class="total">
        <div>
          <span>Total Amount:</span><br>
          <input type="text" name="total_amount" readonly>
        </div>
        <div>
          <span>Total Discount:</span><br>
          <input type="text" name="total_discount" readonly>
        </div>
        <div>
          <span>Net Total:</span><br>
          <input type="text" name="net_total" readonly>
        </div>
        <div>
          <span>Paid Amount:</span><br>
          <input type="text" name="paid_amount">
        </div>
        <div>
          <span>Charge:</span><br>
          <input type="text" name="charge" readonly>
        </div>
      </div>
      <button name="submit" class="save">SAVE</button>
    </section>
    </form>
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
    // JavaScript to handle sidebar toggle on smaller screens
    function toggleSidebar() {
      document.querySelector('.sidebar').classList.toggle('active');
    }

    //add & delete table rows
    document.addEventListener("click", function (event) {
      let tableBody = document.querySelector("tbody");

      if (event.target.closest(".add-row")) {
        let lastRow = tableBody.querySelector("tr:last-child");
        let newRow = lastRow.cloneNode(true);

        newRow.querySelectorAll("input").forEach(input => {
          input.value = "";
        });

        tableBody.appendChild(newRow);
      }

      if (event.target.closest(".delete-row")) {
        let rowToDelete = event.target.closest("tr");
        if (tableBody.rows.length > 1) {
          rowToDelete.remove();
          calculateGrandTotal();
        } else {
          alert("You must have at least one row.");
        }
      }
    });

    //auto select customer details
    document.getElementById("customers").addEventListener("change", function () {
      let selectedOption = this.options[this.selectedIndex];
      let address = selectedOption.getAttribute("data-address") || "";
      let contact = selectedOption.getAttribute("data-contact") || "";

      document.getElementById("address").value = address;
      document.getElementById("contact-number").value = contact;
    })

    //auto select medicine_stock details
    document.addEventListener("DOMContentLoaded", function () {
      document.addEventListener("change", function (event) {
        if (event.target.classList.contains("medicine")) {
          let selectedOption = event.target.options[event.target.selectedIndex];

          let row = event.target.closest("tr");
          row.querySelector(".batch_id").value = selectedOption.getAttribute("data-batch-id") || "";
          row.querySelector(".expire_date").value = selectedOption.getAttribute("data-expire") || "";
          row.querySelector(".mrp").value = selectedOption.getAttribute("data-mrp") || "";
          row.querySelector(".quantity").value = selectedOption.getAttribute("data-quantity") || "";
        }
      });
    });

    // calculate total
    document.addEventListener("input", function (event) {
      if (event.target.closest("tr")) {
        let row = event.target.closest("tr");

        let quantity = parseFloat(row.querySelector("[name='quantity[]']").value) || 0;
        let mrp = parseFloat(row.querySelector("[name='mrp[]']").value) || 0;
        let discount = parseFloat(row.querySelector("[name='discount[]']").value) || 0;

        let total = quantity * mrp;
        total = total - (total * discount / 100);

        row.querySelector("[name='total[]']").value = total.toFixed(2);
      }

      calculateGrandTotal();
    });

    function calculateGrandTotal() {
      let totalAmount = 0;
      let totalDiscount = 0;
      let netTotal = 0;

      document.querySelectorAll("tbody tr").forEach(row => {
        let quantity = parseFloat(row.querySelector("[name='quantity[]']").value) || 0;
        let mrp = parseFloat(row.querySelector("[name='mrp[]']").value) || 0;
        let discount = parseFloat(row.querySelector("[name='discount[]']").value) || 0;

        let rowTotal = quantity * mrp;
        let rowDiscount = (rowTotal * discount) / 100;

        totalAmount += rowTotal;
        totalDiscount += rowDiscount;
        netTotal += (rowTotal - rowDiscount);
      });

      document.querySelector("[name='total_amount']").value = totalAmount.toFixed(2);
      document.querySelector("[name='total_discount']").value = totalDiscount.toFixed(2);
      document.querySelector("[name='net_total']").value = netTotal.toFixed(2);
    }

    document.querySelector("[name='paid_amount']").addEventListener("input", function () {
      let paidAmount = parseFloat(this.value) || 0;
      let netTotal = parseFloat(document.querySelector("[name='net_total']").value) || 0;
      let charge = paidAmount - netTotal;

      document.querySelector("[name='charge']").value = charge.toFixed(2);
    });

  </script>
</body>

</html>