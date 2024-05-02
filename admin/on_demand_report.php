<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$generateReport = new Admin();
$on_demand_report_result = $generateReport->AllOnDemandGeneratedReports();
?>
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">On Demand Generated Report(s)</h3>
    </div>
    <div class="container mt-5">
        
       
        <table id="OnDemandReport" class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Income</th>
                    <th>Total Expenses</th>
                    <th>Net Income</th>
                    <th>Date Generated</th>
                </tr>
            </thead>
            <tbody>
                <?php $count=0; foreach($on_demand_report_result as $report): $count++ ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $report['start_date']; ?></td>
                    <td><?php echo $report['end_date']; ?></td>
                    <td><?php echo $report['total_income']; ?></td>
                    <td><?php echo $report['total_expenses']; ?></td>
                    <td><?php echo $report['net_income']; ?></td>
                    <td><?php echo $report['date_generated']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>


<?php
require_once "footer.php";
?> 
 
