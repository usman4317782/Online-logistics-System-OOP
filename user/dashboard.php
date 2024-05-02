<?php require_once "header.php";?>

<?php
require_once "../classes/User.php";
$fetchUserDetails = new User();
$result = $fetchUserDetails->FetchUserDetails($_SESSION['uid']);
?>

<!-- Main Content -->
<!-- <div class="container mt-5">
    <h2>Welcome to the Logistics Management System</h2>
    <p>This system allows users to manage trips, track shipments, make payments, and generate reports.</p>
    <p>Use the navigation bar above to access different functionalities.</p>
</div> -->

<div class="container mt-5">
<div class="card">
    <div class="card-header">
        User Profile
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Name:</strong> <?php echo $result['name']; ?></p>
                <p><strong>Email:</strong> <?php echo $result['email']; ?></p>
                <p><strong>Address:</strong> <?php echo $result['address']; ?></p>
                <p><strong>Phone Number:</strong> <?php echo $result['phone_number']; ?></p>
            </div>
        </div>
    </div>
</div>
</div>

<?php require_once "footer.php";?>