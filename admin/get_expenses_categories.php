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

// Fetch all expense categories
$query = "SELECT id, type_name FROM expense_type";
$result = $conn->query($query);

// Check if the query was successful
if ($result) {
    $categories = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Handle the error as needed
    $categories = array();
}

// Close the database connection
$conn->close();

// Return the categories as JSON
header('Content-Type: application/json');
echo json_encode($categories);
?>
