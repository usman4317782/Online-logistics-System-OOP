<?php 
require_once "header.php";

// Fetch records for each table
require_once "../classes/Admin.php";
$addFrightAndLogistics = new Admin();
$result = $addFrightAndLogistics->addFrightAndLogistics($_POST);
?>
<div class="container-fluid">
  <div class="d-sm-flex justify-content-between align-items-center mb-4">
    <h3 class="text-dark mb-0">Add Logistics(s)</h3>
    <!-- <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#">
                <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report
            </a> -->
  </div>
  <div class="container mt-5">
    <?php echo $result ?? ""; ?>

    <form action="" method="POST">
      <div class="row g-3">
        <div class="col-md-6 mt-4">
          <label for="freight_details" class="form-label">Freight Details</label>
          <textarea class="form-control" id="freight_details" name="freight_details" rows="3" required
            placeholder="e.g. Transportation of textiles from Karachi to Lahore	"></textarea>
        </div>
        <div class="col-md-6 mt-4">
          <label for="logistics_details" class="form-label">Logistics Details</label>
          <textarea class="form-control" id="logistics_details" name="logistics_details" rows="3" required
            placeholder="e.g. Goods will be transported via road. Estimated delivery time: 2 days.	"></textarea>
        </div>
      </div>
      <div class="row g-3">
        <div class="col-md-6 mt-4">
          <label for="price" class="form-label">Price (in PKr)</label>
          <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required
            placeholder="e.g. 1500.00	">
        </div>
        <div class="col-md-6 mt-4">
          <label for="price" class="form-label">Booking Date (till)</label>
          <input type="date" class="form-control" id="booking_date" name="booking_date" required>
        </div>
      </div>
      <div class="row g-3">
        <div class="col-md-6 mt-4">
          <label for="price" class="form-label">Shipment Date</label>
          <input type="date" class="form-control" id="shipment_date" name="shipment_date" required>
        </div>
      </div>
      <div class="row g-3 mt-3">
        <div class="col-md-12">
          <button type="submit" name="add_details" class="btn btn-outline-primary"><i
              class="fas fa-car"></i>&nbsp;Submit</button>
          <a href="logistics_list.php" class="btn btn-outline-info"><i class="fas fa-list"></i>&nbsp;List</a>
        </div>
      </div>
    </form>

  </div>


</div>


<?php
require_once "footer.php";
?>