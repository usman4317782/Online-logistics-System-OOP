<?php require_once "header.php"; ?>

<?php
require_once "../classes/Admin.php";
$fetchShipmentDetails = new Admin();
// $trips = $fetchTripDetails->FetchTripDetails();
$shipments = $fetchShipmentDetails->FetchShipmentDetails();
if (isset($_GET['action']) and $_GET['action'] == 'shipped') {
    $id = $_GET['id'];
    $fetchShipmentDetails->confirmShipment($id);
}
?>



<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Shipment Details</h2>
            <!-- Display trip details -->
            <?php
            if (isset($fetchShipmentDetails->msg)) {
                echo $fetchShipmentDetails->msg;
            ?>

                <script>
                    // JavaScript redirect after 1 second
                    setTimeout(function() {
                        window.location.href = "shipment_payments.php";
                    }, 1000); // 1000 milliseconds = 1 second
                </script><?php
                        }
                            ?>
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Freight ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Current Route</th>
                        <th>Booking Date</th>
                        <th>Completed Date</th>
                        <th>Last Updated</th>
                        <th>Action</th>
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
                                <td>
                                    <?php
                                    if ($shipment['status'] == 'Completed') {
                                        echo "<p class='text text-success'>" . $shipment['status'] . '</p>';
                                    } else {
                                        echo $shipment['status'];
                                    }
                                    ?>
                                </td>
                                <td><?php echo $shipment['current_route']; ?></td>
                                <td><?php echo $shipment['created_at']; ?></td>
                                <td><?php
                                    if ($shipment['status'] !== 'Pending') {
                                        echo "<p class='text text-success'>" . $shipment['updated_at'] . "</p>";
                                    } else {
                                        echo "<p class='text text-info'>In Processing</p>";
                                    }
                                    ?></td>
                                <td>
                                    <?php echo $shipment['updated_at']; ?>
                                </td>
                                <td>
                                    <?php if ($shipment['status'] !== 'Completed') : ?>
                                        <a href="update_route.php?id=<?php echo $shipment['id']; ?>" class="btn btn-sm btn-outline-info">Update Route</a>
                                        <a onclick="return confirm('Shipment Confirmed!')" href="?action=shipped&id=<?php echo $shipment['id']; ?>" class="btn btn-sm btn-outline-success">Shipped</a>
                                    <?php elseif ($shipment['status'] == 'Pending') : ?>
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