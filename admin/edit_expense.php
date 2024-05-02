<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$updateExpense = new Admin();
$expsesCategories = $updateExpense->fetchAllExpensesTypes();
$result = $updateExpense->udpateExpense($_POST, $_GET);

// Fetch expense details if expense_id is provided in the URL
$expenseDetails = [];
if(isset($_GET['expense_id'])) {
    $expense_id = $_GET['expense_id'];
    $expenseDetails = $updateExpense->fetchExpenseDetails($expense_id);
}
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
        <h3 class="text-dark mb-0">Update Expense</h3>
    </div>
    <div class="container mt-5">
    <?php echo $result ?? ""; ?>

    <form action="" method="POST">
        <div class="row g-3">
            <div class="col-md-6 mt-4">
                <label for="expenseTypeDropdown" class="form-label">Expense Type</label>
                <select class="form-select" id="expenseTypeDropdown" name="expenseTypeDropdown" required>
                    <option value="" selected disabled>Select Expense Type</option>
                    <?php
                    foreach ($expsesCategories as $category) {
                        $selected = ($category['id'] == $expenseDetails['type']) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($category['id']) . '" ' . $selected . '>' . htmlspecialchars($category['type_name']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6 mt-4">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" required value="<?php echo $expenseDetails['amount'] ?? ""?>">
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-12 mt-4">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"><?php echo $expenseDetails['description'] ?? ""?></textarea>
            </div>
        </div>
        <div class="row g-3 mt-3">
            <div class="col-md-12">
                <button type="submit" name="update_expense" class="btn btn-outline-primary"><i class="fas fa-money-bill-alt"></i>&nbsp;Update Expense</button>
                <a href="expenses_list.php" class="btn btn-outline-info"><i class="fas fa-list"></i>&nbsp;Expenses List</a>
            </div>
        </div>
    </form>
</div>
</div>
<?php
require_once "footer.php";
?>
