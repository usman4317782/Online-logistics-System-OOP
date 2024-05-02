<?php
// Assuming you have a database connection class or include your database connection logic here

// Example database connection (replace with your actual connection logic)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logistics_management_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the AJAX request
$data = json_decode(file_get_contents("php://input"));

// Validate and sanitize data if needed
$expenseType = mysqli_real_escape_string($conn, $data->expenseType);
$selectedCategory = mysqli_real_escape_string($conn, $data->selectedCategory);

// Check if the expense type already exists
$checkQuery = "SELECT id FROM expense_type WHERE type_name = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("s", $expenseType);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    // If the expense type already exists, return an error response
    $checkStmt->close();
    $response = array("status" => "error", "message" => "Expense type already exists");
    echo json_encode($response);
} else {
    // If the expense type does not exist, proceed to add it
    $checkStmt->close();

    // Add expense type to the expense_type table
    $query = "INSERT INTO expense_type (type_name) VALUES (?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $expenseType);
        $stmt->execute();
        $stmt->close();

        // Return a success response
        $response = array("status" => "success", "message" => "Expense type added successfully");
        echo json_encode($response);
    } else {
        // Return an error response
        $response = array("status" => "error", "message" => "Error adding expense type");
        echo json_encode($response);
    }
}

// Close the database connection
$conn->close();
?>