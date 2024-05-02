<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$addIncome = new Admin();
$totalIncomes = $addIncome->allIncomes();

// Delete income
if (isset($_GET['income_id'])) {
    $income_id = intval($_GET['income_id']);
    $deleteIncomeResult = $addIncome->deleteIncome($income_id);
}
?>
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Income Detail(s)</h3>
    </div>
    <div class="container mt-5">
        <?php
        if(isset($deleteIncomeResult)){
            echo $deleteIncomeResult;
            ?>
             <script>
                // Set a timeout for 2 seconds (2000 milliseconds)
                setTimeout(function() {
                    // Redirect to the desired page
                    window.location.href = 'income_list.php';
                }, 1000);
            </script>
            <?php
        }
        ?>
        <table id="myTable" class="display table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Source</th>
                    <th>Amount (PKR)</th>
                    <th>Description</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($totalIncomes) {
                    $count = 0;
                    while($income = $totalIncomes->fetch_assoc()){
                        $count ++;
                        ?>
                        <tr>
                            <td><?php echo $count;?></td>
                            <td><?php echo $income['type_name'];?></td>
                            <td><?php echo $income['amount'];?></td>
                            <td><?php echo $income['description'];?></td>
                            <td><?php echo $income['date_added'];?></td>
                            <td>
                                <a href="edit_income.php?income_id=<?php echo $income['income_id']; ?>" title="Edit"><i class="fas fa-edit btn btn-outline-primary"></i></a>
                                <a class="text text-danger" href="?income_id=<?php echo $income['income_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this income?');"><i class="fas fa-trash-alt btn btn-outline-danger"></i></a>
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