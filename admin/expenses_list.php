<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$addExpense = new Admin();
$totalExpenses = $addExpense->allExpenses();

//delete vehicle
if (isset($_GET['expense_id'])) {
    $expense_id = intval($_GET['expense_id']);
    $deleteExpenseResult = $addExpense->deleteExpense($expense_id);
}
?>
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Expense Detail(s)</h3>
        <!-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#">
                <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report
            </a> -->
    </div>
    <div class="container mt-5">
        <?php
            if(isset($deleteExpenseResult)){
                echo $deleteExpenseResult;
                ?>
                 <script>
                    // Set a timeout for 2 seconds (2000 milliseconds)
                    setTimeout(function() {
                        // Redirect to the desired page
                        window.location.href = 'expenses_list.php';
                    }, 1000);
                </script>
                <?php
            }
        ?>
        <table id="myTable" class="display table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Expense Type</th>
                    <th>Amount (PKR)</th>
                    <th>Description</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($totalExpenses) {
                    $count = 0;
                    while($expense = $totalExpenses->fetch_assoc()){
                        $count ++;
                        ?>
                        <tr>
                            <td><?php echo $count;?></td>
                            <td><?php echo $expense['type_name'];?></td>
                            <td><?php echo $expense['amount'];?></td>
                            <td><?php echo $expense['description'];?></td>
                            <td><?php echo $expense['date_added'];?></td>
                            <td>
                                <a href="edit_expense.php?expense_id=<?php echo $expense['expense_id']; ?>" title="Edit"><i class="fas fa-edit btn btn-outline-primary"></i></a>
                                <a class="text text-danger" href="?expense_id=<?php echo $expense['expense_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this expense?');"><i class="fas fa-trash-alt btn btn-outline-danger"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>

    </div>

</div>


<?php
require_once "footer.php";
?>