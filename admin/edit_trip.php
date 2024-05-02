<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$editTrip = new Admin();
$driversData = $editTrip->fetchDriversDetails();
$vehiclesData = $editTrip->fetchVehicleDetails();
//fetch the relevant trip data as per url id
$editTrip->fetchDetailsForTrip(intval($_GET['trip_id']));
//update the URL requested Vehicle ID
$result = $editTrip->editDetailsofTrip($_POST, intval($_GET['trip_id']));
?>
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Edit Trip</h3>
        <!-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#">
                <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report
            </a> -->
    </div>
    <div class="container mt-5">
        <?php
        echo $result ?? "";
        ?>
<form action="" method="POST">
    <div class="row g-3">
        <div class="col-md-6 mt-4">
            <label for="driver_id" class="form-label">Driver</label>
            <select class="form-control" id="driver_id" name="driver_id" required>
                <?php foreach ($driversData as $driver): ?>
                    <option value="<?php echo $driver['driver_id']; ?>" <?php echo ($driver['driver_id'] == $editTrip->driver_id) ? 'selected' : ''; ?>>
                        <?php echo ucwords($driver['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6 mt-4">
            <label for="vehicle_id" class="form-label">Vehicle</label>
            <select class="form-control" id="vehicle_id" name="vehicle_id" required>
                <?php foreach ($vehiclesData as $vehicle): ?>
                    <option value="<?php echo $vehicle['vehicle_id']; ?>" <?php echo ($vehicle['vehicle_id'] == $editTrip->vehicle_id) ? 'selected' : ''; ?>>
                        <?php echo $vehicle['model']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6 mt-4">
            <label for="start_point" class="form-label">Start Point</label>
            <input type="text" class="form-control" id="start_point" name="start_point" required value="<?php echo $editTrip->start_point ?? ""; ?>">
        </div>

        <div class="col-md-6 mt-4">
            <label for="destination" class="form-label">Destination</label>
            <input type="text" class="form-control" id="destination" name="destination" required value="<?php echo $editTrip->destination ?? ""; ?>">
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6 mt-4">
            <label for="distance_covered" class="form-label">Distance Covered</label>
            <input type="text" class="form-control" id="distance_covered" name="distance_covered" required value="<?php echo $editTrip->distance_covered ?? ""; ?>">
        </div>

        <div class="col-md-6 mt-4">
            <label for="charges" class="form-label">Charges</label>
            <input type="text" class="form-control" id="charges" name="charges" required value="<?php echo $editTrip->charges ?? ""; ?>">
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6 mt-4">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required value="<?php echo $editTrip->date ?? ""; ?>">
        </div>

        <div class="col-md-6 mt-4">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" name="time" required value="<?php echo $editTrip->time ?? ""; ?>">
        </div>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-md-12">
            <button type="submit" name="edit_trip" class="btn btn-outline-primary">
                <i class="fas fa-car"></i>&nbsp;Edit Trip
            </button>
            <a href="trips_list.php" class="btn btn-outline-info">
                <i class="fas fa-list"></i>&nbsp;Trips List
            </a>
        </div>
    </div>
</form>
    </div>

</div>


<?php
require_once "footer.php";
?>