<?php require_once "header.php"; ?>

<?php
require_once "../classes/Admin.php";
$updateShipmentDetails = new Admin();
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $updateShipmentDetails->updateShipment($id, $_POST);
}
?>



<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Update Route</h2>
            <?php
            if (isset($updateShipmentDetails->msg)) {
                echo $updateShipmentDetails->msg;
            ?>

                <script>
                    // JavaScript redirect after 1 second
                    setTimeout(function() {
                        window.location.href = "shipment_payments.php";
                    }, 1000); // 1000 milliseconds = 1 second
                </script><?php
                        }
                            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="route">Route</label>
                    <input type="text" class="form-control" name="route" id="route" aria-describedby="helpId" placeholder="Enter Current Route Details e.g City1 to City2 OR Address1 To Address 2" required>
                </div>
                <br>
                <button type="submit" class="btn btn-outline-primary">Update</button>
                <a href="shipment_payments.php" class="btn btn-outline-info">Go to List</a>
            </form>

        </div>
    </div>
</div>


<?php require_once "footer.php"; ?>