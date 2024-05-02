<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$generateReport = new Admin();
$result = $generateReport->GenerateReport($_POST);
?>
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Generate Report(s)</h3>
        <!-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#">
                <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report
            </a> -->
    </div>
    <div class="container mt-5">
        <?php
        echo $result ?? "";
        ?>
        <?php
        if (!empty($generateReport->ShowGeneratedReport())) {
            $generateReport->ShowGeneratedReport();
        }
        ?>
        <h2>Generate Report</h2>
        <!-- <form action="generate_report.php" method="post"> -->
        <form action="" method="post">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="form-group">
                <label for="generation_type">Generation Type:</label>
                <select class="form-control" id="generation_type" name="generation_type" required>
                    <option value="On Demand">On Demand</option>
                    <option value="Monthly">Monthly</option>
                </select>
            </div>
            <br>
            <button type="submit" name="generate_report" class="btn btn-primary">Generate Report</button>
        </form>

    </div>

</div>


<?php
require_once "footer.php";
?>