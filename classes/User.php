<?php

require_once "../lib/Database.php";


class User
{

    private $db;
    public $name, $address, $phone, $email, $password;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function signUp($data)
    {
        if (isset($data['signup']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->name = trim($data['name']);
            $this->address = trim($data['address']);
            $this->phone = trim($data['phone']);
            $this->email = trim($data['email']);
            $this->password = trim($data['password']);
            // Validate Name
            if (empty($this->name) || !preg_match("/^[a-zA-Z ]+$/", $this->name)) {
                return $this->alertMessage("Invalid name. Please enter alphabets and spaces only.", 'danger');
            }

            // Validate Address
            if (empty($this->address) || !preg_match("/^[a-zA-Z0-9#&\/\s]+$/", $this->address)) {
                return $this->alertMessage("Invalid address. Please enter alphanumeric characters, #, &, /, and spaces only.", 'danger');
            }

            // Validate Phone
            if (empty($this->phone) || !preg_match("/^(03|\+92)\d{9}$/", $this->phone)) {
                return $this->alertMessage("Invalid phone number. Please enter a valid Pakistani phone number starting with '03' or '+92'.", 'danger');
            }

            // Validate Email
            if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                return $this->alertMessage("Invalid email address. Please enter a valid email.", 'danger');
            }

            // Check if phone number or email is already registered
            if ($this->isUserExists($this->phone, $this->email)) {
                return $this->alertMessage("Phone number or email already registered.", 'danger');
            }

            // Validate Password
            if (empty($this->password) || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d\s]).{8,}$/", $this->password)) {
                return $this->alertMessage("Invalid password. Please enter mixed characters of password such as lowercase, uppercase, one digit and one special character.", 'danger');
            }


            // If all validations pass, insert user into the database
            $query = "INSERT INTO users (name, address, phone_number, email, password) VALUES ('$this->name', '$this->address', '$this->phone', '$this->email', '$this->password')";
            $stmt = $this->db->insert($query);
            if ($stmt) {
                return $this->alertMessage("Registration successful!", 'success');
            } else {
                return $this->alertMessage("Error: " . $stmt->error, 'danger');
            }
        }
    }

    private function isUserExists($phone, $email)
    {
        $query = "SELECT user_id FROM users WHERE phone_number = '$this->phone' OR email = '$this->email'";
        $stmt = $this->db->select($query);
        return $stmt;
    }

    private function alertMessage($message, $type)
    {
        return '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
                    ' . $message . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
    }

    function Login($data)
    {
        if (isset($data['login']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->email = $data['email'];
            $this->password = $data['password'];
            // Validation checks
            if (empty($this->email && $this->password)) {
                return $this->alertMessage("Error! Field must not be empty", 'danger');
            } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                return $this->alertMessage("Error! Invalid Email", 'danger');
            } else {
                $query = "SELECT * FROM users WHERE email = '$this->email' AND password = '$this->password'";
                $result = $this->db->select($query);
                if ($result) {
                    while ($user = $result->fetch_assoc()) {
                        // Verify the password
                        $_SESSION['loggedin'] = true;
                        $_SESSION['uid'] = $user['user_id'];
                        $_SESSION['uname'] = $user['name'];
                        $_SESSION['uemail'] = $user['email'];
                        header("Location: dashboard.php");
                        exit();
                    }
                } else {
                    // User not found, show error message
                    return $this->alertMessage("Error! User not found", 'danger');
                }
            }
        }
    }

    public function FetchUserDetails($id)
    {
        $query = "SELECT * FROM users WHERE user_id = '$id'";
        $result = $this->db->select($query); // Assuming $this->db is your MySQLi database connection object
        $user = $result->fetch_assoc();
        return $user;
    }

    public function FetchTripDetails()
    {
        // Fetch trip details with driver and vehicle information from the database
        $query = "SELECT trips.trip_id, 
                            trips.start_point, 
                            trips.destination, 
                            trips.distance_covered, 
                            trips.charges, 
                            trips.date, 
                            trips.time,
                            drivers.name AS driver_name,
                            drivers.driver_id AS driver_id,
                            vehicles.vehicle_id,
                            vehicles.registration_number,
                            vehicles.model,
                            vehicles.capacity
                    FROM trips
                    JOIN drivers ON trips.driver_id = drivers.driver_id
                    JOIN vehicles ON trips.vehicle_id = vehicles.vehicle_id";

        $result = $this->db->select($query); // Assuming $this->db is your MySQLi database connection object

        // Initialize an array to store all trip details
        $trips = array();

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Loop through each row and fetch trip details
            while ($row = $result->fetch_assoc()) {
                $trips[] = $row; // Add each row to the trips array
            }
        }

        return $trips;
    }

    public function FetchFrightDetails()
    {
        $query = "SELECT * FROM freight_logistics";
        $result = $this->db->select($query); // Assuming $this->db is your MySQLi database connection object

        // Check if there are rows returned
        if ($result) {
            $frights = array();
            // Fetch each row and store it in the $frights array
            while ($row = $result->fetch_assoc()) {
                $frights[] = $row;
            }
            return $frights;
        } else {
            // No rows found
            return array();
        }
    }


    public function FetchShipmentDetails($userId)
    {
        // Assuming $this->db is your MySQLi database connection object
        $query = "SELECT * FROM payments WHERE user_id = '$userId'";
        $result = $this->db->select($query);

        if ($result) {
            $payments = array();
            while ($row = $result->fetch_assoc()) {
                $payments[] = $row;
            }
            return $payments;
            
        } else {
            return array(); // No rows found
        }
    }
}
