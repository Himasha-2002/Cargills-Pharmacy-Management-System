<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Medicine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .btn-primary {
            background-color: #02b6ff;
            border-color: #02b6ff;
        }
        .btn-primary:hover {
            background-color: #0099d6;
            border-color: #0099d6;
        }
        hr {
            border-top: 2px solid #02b6ff;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Add New Medicine</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($_SESSION['errors'])): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <p class="mb-0"><?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php unset($_SESSION['errors']); endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success'] ?>
                    </div>
                <?php unset($_SESSION['success']); endif; ?>

                <form method="post">
                    <div class="row col col-md-12">
                      <div class="col col-md-8 form-group">
                        <label class="font-weight-bold" for="medicine_name">Medicine Name :</label>
                        <input type="text" class="form-control" name="medicine_name" id="medicine_name" placeholder="Medicine Name" onblur="notNull(this.value, 'medicine_name_error');" required>
                        <code class="text-danger small font-weight-bold float-right" id="medicine_name_error" style="display: none;"></code>
                      </div>
                      <div class="col col-md-4 form-group">
                        <label class="font-weight-bold" for="packing">Packing :</label>
                        <input type="text" class="form-control" name="packing" id="packing" placeholder="Packing e.g. 10 TAB / 100 ML" onblur="notNull(this.value, 'pack_error');" required>
                        <code class="text-danger small font-weight-bold float-right" id="pack_error" style="display: none;"></code>
                      </div>
                    </div>
                    <div class="row col col-md-12">
                      <div class="col col-md-12 form-group">
                        <label class="font-weight-bold" for="generic_name">Generic Name :</label>
                        <input type="text" class="form-control" name="generic_name" id="generic_name" placeholder="Generic Name" onblur="notNull(this.value, 'generic_name_error');" required>
                        <code class="text-danger small font-weight-bold float-right" id="generic_name_error" style="display: none;"></code>
                      </div>
                    </div>
                    <div class="row col col-md-12">
                      <div class="col col-md-12 form-group">
                        <label class="font-weight-bold" for="supplier_name">Supplier :</label>
                        <input id="supplier_name" type="text" class="form-control" name="supplier_name" placeholder="Supplier Name" onkeyup="showSuggestions(this.value, 'supplier');" required>
                        <code class="text-danger small font-weight-bold float-right" id="supplier_name_error" style="display: none;"></code>
                        <div id="supplier_suggestions" class="list-group position-fixed" style="z-index: 1; width: 35.80%; overflow: auto; max-height: 200px;"></div>
                      </div>
                    </div>
                    <div class="row col col-md-12">
                      <div class="col col-md-5 font-weight-bold" style="color: green;cursor:pointer" onclick="document.getElementById('add_new_supplier_model').style.display = 'block';">
                        <i class="fa fa-plus"></i> Add New Supplier
                      </div>
                    </div>
                    <hr>

                    <!-- Additional fields from original form -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="font-weight-bold" for="batch_id">Batch ID:</label>
                            <input type="text" class="form-control" id="batch_id" name="batch_id" required>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold" for="expiry_date">Expiry Date (MM/YYYY):</label>
                            <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="e.g., 12/2025" required>
                        </div>
                        <div class="col-md-4">
                            <label class="font-weight-bold" for="quantity">Quantity:</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="font-weight-bold" for="mrp">MRP:</label>
                            <input type="number" step="0.01" class="form-control" id="mrp" name="mrp" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="font-weight-bold" for="rate">Rate:</label>
                            <input type="number" step="0.01" class="form-control" id="rate" name="rate" min="0" required>
                        </div>
                    </div>

                    <div class="col col-md-12">
                      <hr class="col-md-12 float-left" style="padding: 0px; width: 95%; border-top: 2px solid  #02b6ff;">
                    </div>
                    <!-- submit button -->
                    <div class="row col col-md-12">
                      &emsp;
                      <div class="form-group m-auto">
                        <button type="submit" class="btn btn-primary form-control" onclick="addMedicine();">ADD</button>
                      </div>
                    </div>
                    <!-- result message -->
                    <div id="medicine_acknowledgement" class="col-md-12 h5 text-success font-weight-bold text-center" style="font-family: sans-serif;"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add New Supplier Modal -->
    <div id="add_new_supplier_model" class="modal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Supplier</h5>
                    <button type="button" class="btn-close" onclick="document.getElementById('add_new_supplier_model').style.display = 'none';"></button>
                </div>
                <div class="modal-body">
                    <!-- Supplier form fields would go here -->
                    <div class="form-group">
                        <label>Supplier Name:</label>
                        <input type="text" class="form-control" id="new_supplier_name">
                    </div>
                    <div class="form-group mt-3">
                        <label>Contact Number:</label>
                        <input type="text" class="form-control" id="new_supplier_contact">
                    </div>
                    <div class="form-group mt-3">
                        <label>Address:</label>
                        <textarea class="form-control" id="new_supplier_address"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('add_new_supplier_model').style.display = 'none';">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveNewSupplier()">Save Supplier</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation functions
        function notNull(value, error_id) {
            if(value === "") {
                document.getElementById(error_id).style.display = "block";
                document.getElementById(error_id).innerHTML = "This field cannot be empty";
                return false;
            }
            else {
                document.getElementById(error_id).style.display = "none";
                return true;
            }
        }

        // Function to show supplier suggestions
        function showSuggestions(str, type) {
            if(str.length === 0) {
                document.getElementById(type + "_suggestions").innerHTML = "";
                return;
            }
            
            // Here you would typically make an AJAX request to get suggestions
            // This is a placeholder for demonstration
            const dummySuggestions = ["Supplier A", "Supplier B", "Sample Pharma", "Sun Pharmaceuticals"];
            const filteredSuggestions = dummySuggestions.filter(s => s.toLowerCase().includes(str.toLowerCase()));
            
            let suggestionHTML = "";
            filteredSuggestions.forEach(suggestion => {
                suggestionHTML += `<a href="#" class="list-group-item list-group-item-action" 
                                    onclick="selectSupplier('${suggestion}')">${suggestion}</a>`;
            });
            
            document.getElementById(type + "_suggestions").innerHTML = suggestionHTML;
        }

        function selectSupplier(name) {
            document.getElementById("supplier_name").value = name;
            document.getElementById("supplier_suggestions").innerHTML = "";
        }

        function saveNewSupplier() {
            // This would typically be an AJAX request to save the supplier
            const name = document.getElementById("new_supplier_name").value;
            if(name) {
                document.getElementById("supplier_name").value = name;
                document.getElementById("add_new_supplier_model").style.display = "none";
                // Show success message
                alert("New supplier added successfully!");
            } else {
                alert("Please enter supplier name");
            }
        }

        function addMedicine() {
            // Validate form before submission
            const medicine_name = document.getElementById("medicine_name").value;
            const packing = document.getElementById("packing").value;
            const generic_name = document.getElementById("generic_name").value;
            const supplier_name = document.getElementById("supplier_name").value;
            
            if(notNull(medicine_name, "medicine_name_error") && 
               notNull(packing, "pack_error") && 
               notNull(generic_name, "generic_name_error") && 
               notNull(supplier_name, "supplier_name_error")) {
                // Form would be submitted here
                document.getElementById("medicine_acknowledgement").innerHTML = "Medicine added successfully!";
            }
        }
    </script>
</body>
</html>