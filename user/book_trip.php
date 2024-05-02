<?php require_once "header.php"; ?>

<?php
require_once "../classes/User.php";
$fetchFrightDetails = new User();
// $trips = $fetchTripDetails->FetchTripDetails();
$frights = $fetchFrightDetails->FetchFrightDetails();
?>



<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Freight Details</h2>
            <!-- Display trip details -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Logistics ID</th>
                        <th>Freight Details</th>
                        <th>Logistics Details</th>
                        <th>Price</th>
                        <th>Booking Date</th>
                        <th>Shipment Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($frights)) : ?>
                    <tr>
                        <td colspan="7">No record found</td>
                    </tr>
                    <?php else : ?>
                    <?php foreach ($frights as $logistics) : ?>
                    <?php 
                    // Check if booking date is in the future
                    $booking_date = strtotime($logistics['booking_date']);
                    $current_date = strtotime(date('Y-m-d'));
                    $booking_enabled = ($booking_date >= $current_date);
                ?>
                    <tr>
                        <td><?php echo $logistics['id']; ?></td>
                        <td><?php echo $logistics['freight_details']; ?></td>
                        <td><?php echo $logistics['logistics_details']; ?></td>
                        <td><?php echo $logistics['price']; ?></td>
                        <td><?php echo $logistics['booking_date']; ?></td>
                        <td><?php echo $logistics['shipment_date']; ?></td>
                        <td>
                            <?php if ($booking_enabled) : ?>
                            <a href="payment/index.php?id=<?php echo $logistics['id']; ?>&user_id=<?php echo $_SESSION['uid']?>&amount=<?php echo $logistics['price']; ?>"
                                class="btn btn-primary">Book Now</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>


<?php require_once "footer.php"; ?>