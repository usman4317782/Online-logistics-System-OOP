<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$driversList = new Admin();
// $result = $addVehicles->addVehicle($_POST);
$totalDrivers = $driversList->allDrivers();

//delete vehicle
if (isset($_GET['driver_id'])) {
    $driver_id = intval($_GET['driver_id']);
    $deleteDriverResult = $driversList->deleteDriver($driver_id);
}
?>
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Registered Driver(s)</h3>
        <!-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#">
                <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report
            </a> -->
    </div>
    <div class="container mt-5">
        <?php
            if(isset($deleteDriverResult)){
                echo $deleteDriverResult;
                ?>
                 <script>
                    // Set a timeout for 2 seconds (2000 milliseconds)
                    setTimeout(function() {
                        // Redirect to the desired page
                        window.location.href = 'drivers_list.php';
                    }, 1000);
                </script>
                <?php
            }
        ?>
        <table id="myTable" class="display table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Sr. #</th>
                    <th>Driver ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>CNIC</th>
                    <th>License Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($totalDrivers) {
                    $count = 0;
                    while($drivers = $totalDrivers->fetch_assoc()){
                        $count ++;
                        ?>
                        <tr>
                            <td><?php echo $count;?></td>
                            <td><?php echo $drivers['driver_id'];?></td>
                            <td><?php echo ucwords($drivers['name']);?></td>
                            <td><?php echo $drivers['contact'];?></td>
                            <td><?php echo $drivers['cnic'];?></td>
                            <td><?php echo $drivers['license_number'];?></td>
                            <td>
                                <a href="edit_driver.php?driver_id=<?php echo $drivers['driver_id']; ?>" title="Edit"><i class="fas fa-edit btn btn-outline-primary"></i></a>
                                <a class="text text-danger" href="?driver_id=<?php echo $drivers['driver_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this vehicle?');"><i class="fas fa-trash-alt btn btn-outline-danger"></i></a>
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