<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$addVehicles = new Admin();
// $result = $addVehicles->addVehicle($_POST);
$totalVehicles = $addVehicles->allVehicles();

//delete vehicle
if (isset($_GET['vehicle_id'])) {
    $vehicle_id = intval($_GET['vehicle_id']);
    $deleteVehicleResult = $addVehicles->deleteVehicles($vehicle_id);
}
?>
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Registered Vehicle(s)</h3>
        <!-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#">
                <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report
            </a> -->
    </div>
    <div class="container mt-5">
        <?php
            if(isset($deleteVehicleResult)){
                echo $deleteVehicleResult;
                ?>
                 <script>
                    // Set a timeout for 2 seconds (2000 milliseconds)
                    setTimeout(function() {
                        // Redirect to the desired page
                        window.location.href = 'vehicles_list.php';
                    }, 1000);
                </script>
                <?php
            }
        ?>
        <table id="myTable" class="display table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Sr. #</th>
                    <th>Vehicle ID</th>
                    <th>Registration Number</th>
                    <th>Model</th>
                    <th>Capacity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($totalVehicles) {
                    $count = 0;
                    while($vehicles = $totalVehicles->fetch_assoc()){
                        $count ++;
                        ?>
                        <tr>
                            <td><?php echo $count;?></td>
                            <td><?php echo $vehicles['vehicle_id'];?></td>
                            <td><?php echo $vehicles['registration_number'];?></td>
                            <td><?php echo $vehicles['model'];?></td>
                            <td><?php echo $vehicles['capacity'];?></td>
                            <td>
                                <a href="edit_vehicle.php?vehicle_id=<?php echo $vehicles['vehicle_id']; ?>" title="Edit"><i class="fas fa-edit btn btn-outline-primary"></i></a>
                                <a class="text text-danger" href="?vehicle_id=<?php echo $vehicles['vehicle_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this vehicle?');"><i class="fas fa-trash-alt btn btn-outline-danger"></i></a>
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