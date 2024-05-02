<?php
require('config.php');

if (isset($_POST['stripeToken'])) {
	\Stripe\Stripe::setVerifySslCerts(false);

	$token = $_POST['stripeToken'];
	$amount = $_POST['amount'];

	// Convert the amount to paisa (since you're using PKR)
	$amount_in_paisa = intval($amount * 100); // Assuming $amount is in PKR

	// Ensure that the amount is at least 50 paisa (or 1 PKR, whichever is higher)
	$minimum_amount_in_paisa = 50; // 50 paisa
	$amount_in_paisa = max($amount_in_paisa, $minimum_amount_in_paisa);

	$data = \Stripe\Charge::create(array(
		"amount" => $amount_in_paisa,
		"currency" => "pkr",
		"description" => "Payment System For Freights",
		"source" => $token,
	));

	$conn = new mysqli("localhost", "root", "", "logistics_management_system");

	// Retrieve POST data
	$user_id = $_POST['user_id'];
	$freight_id = $_POST['freight_id'];
	$amount = $_POST['amount'];
	$stripe_charge_id = $data->id; // Assuming $data contains the Stripe charge object

	// Prepare SQL statement
	$sql = "INSERT INTO payments (user_id, freight_id, amount, stripe_charge_id, status, current_route) VALUES (?, ?, ?, ?, ?, ?)";
	$stmt = $conn->prepare($sql);

	if ($stmt === false) {
		echo "Error: " . $conn->error;
		exit;
	}

	$status = "Pending";
	$current_status = "In Processing";
	// Bind parameters and execute statement
	$stmt->bind_param("iiisss", $user_id, $freight_id, $amount, $stripe_charge_id, $status, $current_status);
	if ($stmt->execute()) {

		// Display success message
		echo "Payment successful. Redirecting in 2 seconds...";
		// Redirect after 2 seconds
		header("refresh:2;url=../book_trip.php");
		exit;
	}else {
		echo "Error: " . $stmt->error;
	}
}
