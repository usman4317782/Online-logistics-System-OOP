<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$fright = new Admin();
// $result = $addVehicles->addVehicle($_POST);
$frightData = $fright->fetchFrightLogisticsDetails();

//delete vehicle
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $deleteResult = $fright->deleteFrightAndLogistics($id);
}
?>
<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Registered Fright(s)</h3>
        <!-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#">
                <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report
            </a> -->
    </div>
    <div class="container mt-5">
        <?php
            if(isset($deleteResult)){
                echo $deleteResult;
                ?>
        <script>
            // Set a timeout for 2 seconds (2000 milliseconds)
            setTimeout(function () {
                // Redirect to the desired page
                window.location.href = 'logistics_list.php';
            }, 1000);
        </script>
        <?php
            }
        ?>
        <table id="myTable" class="display table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Sr. #</th>
                    <th>Freight Details</th>
                    <th>Logistics Details</th>
                    <th>Price (Pkr)</th>
                    <th>Booking Date (till)</th>
                    <th>Shipment Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 if ($frightData) {
                    $count = 0;
                    foreach ($frightData as $data) {
                        $count ++;
                        ?>
                <tr>
                <td><?php echo $count; ?></td>
                    <td><?php echo $data['freight_details']; ?></td>
                    <td><?php echo $data['logistics_details']; ?></td>
                    <td><?php echo $data['price']; ?></td>
                    <td><?php echo $data['booking_date']; ?></td>
                    <td><?php echo $data['shipment_date']; ?></td>
                    <td>
                        <a href="edit_logistics.php?id=<?php echo $data['id']; ?>" title="Edit"><i
                                class="fas fa-edit btn btn-outline-primary"></i></a>
                        <a class="text text-danger" href="?id=<?php echo $data['id']; ?>"
                            title="Delete" onclick="return confirm('Are you sure you want to delete the record?');"><i
                                class="fas fa-trash-alt btn btn-outline-danger"></i></a>
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