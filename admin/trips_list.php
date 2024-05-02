<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$allTrips = new Admin();
// $result = $addVehicles->addVehicle($_POST);
$totalTrips = $allTrips->allTrips();

//delete vehicle
if (isset($_GET['trip_id'])) {
    $trip_id = intval($_GET['trip_id']);
    $deleteTripResult = $allTrips->deleteTrip($trip_id);
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
            if(isset($deleteTripResult)){
                echo $deleteTripResult;
                ?>
                 <script>
                    // Set a timeout for 2 seconds (2000 milliseconds)
                    setTimeout(function() {
                        // Redirect to the desired page
                        window.location.href = 'trips_list.php';
                    }, 1000);
                </script>
                <?php
            }
        ?>
        <table id="myTable" class="display table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Sr. #</th>
                    <th>Trip ID</th>
                    <th>Vechile ID With Details</th>
                    <th>Driver ID With Details</th>
                    <th>Start Point</th>
                    <th>Destination</th>
                    <th>Distance Covered</th>
                    <th>Charges</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($totalTrips) {
                    $count = 0;
                    while ($trip = $totalTrips->fetch_assoc()) {
                        $count++;
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $trip['trip_id']; ?></td>
                            <td>
                                <?php
                                echo $trip['vehicle_id'];
                                // Fetch details of the vehicle
                                $vehicleDetails = $allTrips->getVehicleDetails($trip['vehicle_id']); // Assuming you have a function to get vehicle details
                                if ($vehicleDetails) {
                                    echo ' - ' . $vehicleDetails['registration_number'] . ' (' . $vehicleDetails['model'] . ')';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $trip['driver_id'];
                                // Fetch details of the driver
                                $driverDetails = $allTrips->getDriverDetails($trip['driver_id']); // Assuming you have a function to get driver details
                                if ($driverDetails) {
                                    echo ' - ' . $driverDetails['name'];
                                }
                                ?>
                            </td>
                            <td><?php echo $trip['start_point']; ?></td>
                            <td><?php echo $trip['destination']; ?></td>
                            <td><?php echo $trip['distance_covered']; ?></td>
                            <td><?php echo $trip['charges']; ?></td>
                            <td>
                            <?php
                            echo $trip['date'] ? date('d/m/y', strtotime($trip['date'])) : '';
                            ?>
                            </td>
                            <td>
                                <?php
                                echo $trip['time'] ? date('h:i A', strtotime($trip['time'])) : '';
                                ?>
                            </td>
                            <td>
                                <a href="edit_trip.php?trip_id=<?php echo $trip['trip_id']; ?>" title="Edit"><i class="fas fa-edit btn btn-outline-primary"></i></a>
                                <a class="text text-danger" href="?trip_id=<?php echo $trip['trip_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this trip?');"><i class="fas fa-trash-alt btn btn-outline-danger"></i></a>
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