<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$editDriver = new Admin();
//fetch the vehicle data which id is in the URL
$editDriver->fetchDetailsForDriver(intval($_GET['driver_id']));
//update the URL requested Vehicle ID
$result = $editDriver->editDetailsofDriver($_POST, intval($_GET['driver_id']));
?>
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Edit Driver</h3>
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
                <label for="name" class="form-label">Driver Name</label>
                <input type="text" class="form-control" id="name" name="name" required value="<?php echo $editDriver->name ?? "";?>">
            </div>

            <div class="mb-3">
                <label for="contact" class="form-label">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" required value="<?php echo $editDriver->contact ?? "";?>">
            </div>

            <div class="mb-3">
                <label for="cnic" class="form-label">CNIC Number</label>
                <input type="text" class="form-control" id="cnic" name="cnic" required value="<?php echo $editDriver->cnic ?? "";?>">
            </div>

            <div class="mb-3">
                <label for="license_number" class="form-label">License Number</label>
                <input type="text" class="form-control" id="license_number" name="license_number" required value="<?php echo $editDriver->license_number ?? "";?>">
            </div>

            <button type="submit" name="edit_driver" class="btn btn-outline-primary"><i class="fas fa-user"></i>&nbsp;Edit Driver</button>
            <a href="drivers_list.php" class="btn btn-outline-info"><i class="fas fa-list"></i>&nbsp; Driver List</a>
        </form>
    </div>

</div>


<?php
require_once "footer.php";
?>