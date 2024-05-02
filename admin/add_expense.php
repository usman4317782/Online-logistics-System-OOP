<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$addExpense = new Admin();
$expsesCategories = $addExpense->fetchAllExpensesTypes();
$result = $addExpense->addNewExpense($_POST);
?>
<!-- Your custom styles go here -->
<style>
    /* Style for the popup container */
    .popup-container {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }
</style>

<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Add Expense(s)</h3>
        <!-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#">
                <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report
            </a> -->
    </div>
    <div class="container mt-5">
    <?php echo $result ?? ""; ?>

    <form action="" method="POST">
        <div class="row g-3">
            <!-- <div class="col-md-6 mt-4">
                <label for="type" class="form-label">Expense Type</label>
                <input type="text" class="form-control" id="type" name="type" required>
            </div> -->

            <div class="col-md-6 mt-4">
                <label for="expenseTypeDropdown" class="form-label">Expense Type</label>
                <select class="form-select" id="expenseTypeDropdown" name="expenseTypeDropdown" required >
                    <option value="" selected disabled>Select Expense Type</option>
                    <?php
                    foreach ($expsesCategories as $category) {
                        echo '<option value="' . htmlspecialchars($category['id']) . '">' . htmlspecialchars($category['type_name']) . '</option>';
                    }
                    ?>
                </select>
            </div>


            
            <div class="col-md-6 mt-4">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" required value="<?php echo $addExpense->amount  ?? ""?>">
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-12 mt-4">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"><?php echo $addExpense->description ?? ""?></textarea>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-12">
                <button type="submit" name="add_expense" class="btn btn-outline-primary"><i class="fas fa-money-bill-alt"></i>&nbsp;Add Expense</button>
                <a href="expenses_list.php" class="btn btn-outline-info"><i class="fas fa-list"></i>&nbsp;Expenses List</a>
            </div>
        </div>
    </form>

</div>
<div class="row g-3 mt-3 container">
        <div class="col-md-12">
            <!-- Add Expense Type Button -->
            <button id="addExpenseTypeBtn" class="btn btn-outline-success" onclick="showPopup()"><i class="fas fa-plus"></i>&nbsp;Add Expense Type</button>
                <!-- Popup Container for Adding Expense Type -->
                <div id="expenseTypePopup" class="popup-container">
                    <h2>Add Expense Type</h2>
                    <form id="expenseTypeForm">
                        <div class="form-group">
                            <label for="expenseType">Expense Type:</label>
                            <input type="text" class="form-control" id="expenseType" name="expenseType" required>
                        </div>
                        <!-- Display categories fetched from PHP -->
                        <div class="form-group">
                            <label for="existingCategories">Existing Categories:</label>
                            <select class="form-control" id="existingCategories">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo $category['type_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <br>
                        <button type="button" class="btn btn-outline-primary" onclick="addExpenseType()">Add</button>
                        <button type="button" class="btn btn-outline-danger" onclick="closePopup()">Cancel</button>
                    </form>
                </div>
        </div>
    </div>


</div>





<?php
require_once "footer.php";
?>

<!-- Your existing scripts go here -->

<script>
    // Function to show the popup
    function showPopup() {
        document.getElementById("expenseTypePopup").style.display = "block";
        
        // Fetch categories using AJAX
        fetchCategories();
    }

    // Function to close the popup
    function closePopup() {
        document.getElementById("expenseTypePopup").style.display = "none";
    }

    // Function to add a new expense type (you can customize this)
    // Function to add a new expense type (you can customize this)
    function addExpenseType() {
        // Fetch data from the form
        var expenseType = document.getElementById("expenseType").value;
        var selectedCategory = document.getElementById("existingCategories").value;

        // Check if expenseType is empty
        if (expenseType.trim() === "") {
            alert("Expense Type cannot be empty.");
            return;
        }

        // Perform additional validation if needed

        // Send data to the server using AJAX or your preferred method
        // Example AJAX using fetch:
        fetch('add_expense_type.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ expenseType: expenseType, selectedCategory: selectedCategory }),
        })
        .then(response => response.json())
        .then(data => {
            // Log the response to the console for debugging
            console.log('Server Response:', data);

            // Handle the response from the server (success or error)
            // Display a user-readable message based on the status
            if (data.status === 'success') {
                alert('Success: ' + data.message);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch((error) => {
            alert('Error: ' + error);
        });


        // Close the popup after adding expense type
        closePopup();
    }


    // Function to fetch categories using AJAX
    function fetchCategories() {
        fetch('get_expenses_categories.php')
            .then(response => response.json())
            .then(data => {
                // Populate the existingCategories dropdown
                var select = document.getElementById("existingCategories");
                select.innerHTML = "";

                data.forEach(category => {
                    var option = document.createElement("option");
                    option.value = category.id;
                    option.text = category.type_name;
                    select.add(option);
                });
            })
            .catch((error) => {
                alert('Error fetching categories:', error);
            });
    }
</script>