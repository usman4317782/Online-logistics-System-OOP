<?php require_once "header.php"; ?>

<?php
require_once "../classes/User.php";
$fetchShipmentDetails = new User();
// $trips = $fetchTripDetails->FetchTripDetails();
$shipments = $fetchShipmentDetails->FetchShipmentDetails($_SESSION['uid']);
?>



<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Shipment Details</h2>
            <!-- Display trip details -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Freight ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Current Route</th>
                        <th>Booking Date</th>
                        <th>Completed Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($shipments)) : ?>
                    <tr>
                        <td colspan="6">No shipment records found</td>
                    </tr>
                    <?php else : ?>
                    <?php foreach ($shipments as $shipment) : ?>
                    <tr>
                        <td><?php echo $shipment['id']; ?></td>
                        <td><?php echo $shipment['freight_id']; ?></td>
                        <td><?php echo $shipment['amount']; ?></td>
                        <td><?php echo $shipment['status']; ?></td>
                        <td><?php echo $shipment['current_route']; ?></td>
                        <td><?php echo $shipment['created_at']; ?></td>
                        <td><?php 
                        if ($shipment['status'] !=='Pending') {
                            echo "<p class='text text-success'>" .$shipment['updated_at']."</p>";
                        }else{
                            echo "<p class='text text-info'>In Processing</p>";
                        }
                         ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>


        </div>
    </div>
</div>


<?php require_once "footer.php"; ?>