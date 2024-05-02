<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$editVehicles = new Admin();
//fetch the vehicle data which id is in the URL
$editVehicles->fetchDetails(intval($_GET['vehicle_id']));
//update the URL requested Vehicle ID
$result = $editVehicles->editDetails($_POST, intval($_GET['vehicle_id']));
?>
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Edit Vehicle</h3>
        <!-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#">
                <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report
            </a> -->
    </div>
    <div class="container mt-5">
        <?php
        echo $result ?? "";
        ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="registrationNumber" class="form-label">Registration Number</label>
                <input type="text" class="form-control" id="registrationNumber" name="registrationNumber" required value="<?php echo $editVehicles->reg_number ?? "";?>">
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" required value="<?php echo $editVehicles->model ?? "";?>">
            </div>

            <div class="mb-3">
                <label for="capacity" class="form-label">Capacity (<small>Enter Total seating capacity of people</small>)</label>
                <input type="number" class="form-control" id="capacity" name="capacity" required value="<?php echo $editVehicles->capacity ?? "";?>">
            </div>

            <button type="submit" name="edit_vehicle" class="btn btn-outline-primary"><i class="fas fa-car"></i>&nbsp;Edit Vehicle</button>
            <a href="vehicles_list.php" class="btn btn-outline-info"><i class="fas fa-list"></i>&nbsp; Vehicle List</a>
        </form>
    </div>

</div>


<?php
require_once "footer.php";
?>