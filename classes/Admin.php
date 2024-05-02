<?php

require_once "../lib/Database.php";


class Admin
{

    private $db;
    public $name, $address, $phone, $email, $password, $role, $reg_number, $model, $capacity;
    public $contact, $cnic, $license_number, $freight_details, $logistics_details, $price, $booking_date, $shipment_date, $msg;

    public $driver_id;
    public $vehicle_id;
    public $start_point;
    public $destination;
    public $distance_covered;
    public $date;
    public $charges, $time, $type, $amount, $description;

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
            $this->role = trim($data['role']);
            // Validate Name
            if (empty($this->name) || !preg_match("/^[a-zA-Z ]+$/", $this->name)) {
                return $this->alertMessage("Invalid name. Please enter alphabets and spaces only.", 'danger');
            }

            // Validate Name
            if (empty($this->role) || !preg_match("/^[a-zA-Z_ ]+$/", $this->role)) {
                return $this->alertMessage("Invalid role. Please enter alphabets, underscore and spaces only.", 'danger');
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
            if ($this->isAdminExists()) {
                return $this->alertMessage("Phone number or email already registered.", 'danger');
            }

            // Check if phone number or email is already registered
            if ($this->isAdminRoleExists()) {
                return $this->alertMessage("Admin already exists against the current role.", 'danger');
            }

            // Validate Password
            if (empty($this->password) || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d\s]).{8,}$/", $this->password)) {
                return $this->alertMessage("Invalid password. Please enter mixed characters of password such as lowercase, uppercase, one digit and one special character.", 'danger');
            }


            // If all validations pass, insert admin into the database
            $query = "INSERT INTO admin (name, address, phone_number, email, password, role)
            VALUES ('$this->name', '$this->address', '$this->phone', '$this->email', '$this->password', '$this->role')";
            $stmt = $this->db->insert($query);
            if ($stmt) {
                return $this->alertMessage("Registration successful!", 'success');
            } else {
                return $this->alertMessage("Error: " . $stmt->error, 'danger');
            }
        }
    }

    private function isAdminExists()
    {
        $query = "SELECT admin_id FROM admin WHERE phone_number = '$this->phone' OR email = '$this->email'";
        $stmt = $this->db->select($query);
        return $stmt;
    }

    private function isAdminRoleExists()
    {
        $query = "SELECT admin_id FROM admin WHERE role = '$this->role'";
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
                $query = "SELECT * FROM admin WHERE email = '$this->email' AND password = '$this->password'";
                $result = $this->db->select($query);
                if ($result) {
                    while ($admin = $result->fetch_assoc()) {
                        // Verify the password
                        $_SESSION['loggedin'] = true;
                        $_SESSION['aid'] = $admin['admin_id'];
                        $_SESSION['aname'] = $admin['name'];
                        $_SESSION['aemail'] = $admin['email'];
                        header("Location: dashboard.php");
                        exit();
                    }
                } else {
                    // Admin not found, show error message
                    return $this->alertMessage("Error! Admin not found", 'danger');
                }
            }
        }
    }

    function fetchRegisteredVehicles()
    {
        $query = "SELECT COUNT(*) AS totalVehiclesCount FROM vehicles;";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            // Return the total count of registered vehicles
            return $row['totalVehiclesCount'];
        } else {
            // Handle the case where no vehicles are registered
            return 0;
        }
    }
    function fetchRegisteredDrivers()
    {
        $query = "SELECT COUNT(*) AS totalDriversCount FROM drivers;";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            // Return the total count of registered vehicles
            return $row['totalDriversCount'];
        } else {
            // Handle the case where no vehicles are registered
            return 0;
        }
    }
    function fetchTripDetails()
    {
        $query = "SELECT COUNT(*) AS totalTripsCount FROM trips;";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            // Return the total count of registered vehicles
            return $row['totalTripsCount'];
        } else {
            // Handle the case where no vehicles are registered
            return 0;
        }
    }
    function fetchCompanyExpenses()
    {
        $query = "SELECT SUM(amount) AS totalExpenses FROM expenses;";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            // Return the total count of registered vehicles
            return $row['totalExpenses'];
        } else {
            // Handle the case where no vehicles are registered
            return 0;
        }
    }
    function fetchIncomeDetails()
    {
        $query = "SELECT SUM(amount) AS totalIncome FROM income;";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            // Return the total count of registered vehicles
            return $row['totalIncome'];
        } else {
            // Handle the case where no vehicles are registered
            return 0;
        }
    }

    function fetchMonthlyReports()
    {
        $query = "SELECT COUNT(*) AS totalMonthlyReports FROM reports;";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            // Return the total count of registered vehicles
            return $row['totalMonthlyReports'];
        } else {
            // Handle the case where no vehicles are registered
            return 0;
        }
    }
    function fetchTotalShipments()
    {
        $query = "SELECT COUNT(*) AS totalShipments FROM payments;";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            // Return the total count of shipments
            return $row['totalShipments'];
        } else {
            // Handle the case where no shipments are found
            return 0;
        }
    }


    function addVehicle($data)
    {
        if (isset($data['add_vehicle']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->reg_number = $this->db->link->real_escape_string(trim($data['registrationNumber']));
            $this->model = $this->db->link->real_escape_string(trim(ucwords($data['model'])));
            $this->capacity = $this->db->link->real_escape_string(trim($data['capacity']));
            if (empty($this->reg_number and $this->model and $this->capacity)) {
                return $this->alertMessage("All fields are required.", 'danger');
            }
            // Validate Vehicle Number
            if (!preg_match("/^[A-Z]{1,3}-[0-9]{1,4}(?:-[0-9]{1,2})?$/", $this->reg_number)) {
                return $this->alertMessage("Invalid Registration Number <br>. <ol><li>Start with one to three uppercase letters</li><li>A hyphen is used to separate the letters and numbers.</li><li>Match one to four digits (mandatory part)</li><li>An additional hyphen followed by one or two digits for the year of registration. (Optional)</li><li><b>Example: ABC-1234 OR ABC-1234-11</b></li>", 'danger');
            }
            // Validate Model
            if (!preg_match("/^[a-zA-Z][a-zA-Z0-9_\s-]*$/", $this->model)) {
                return $this->alertMessage("Invalid Car Model - <br> Car Model should start and end with one or more lowercase or uppercase letters, digits, underscores, hyphens, or white spaces.", 'danger');
            }
            // Check existence of Registration Number
            if ($this->isRegistrationNumberUnique($this->reg_number) == true) {
                return $this->alertMessage("Error! Car Registration Number already registered.", 'danger');
            }

            // Check existence of Model
            // if ($this->isModelUnique($this->model) == true) {
            //     return $this->alertMessage("Error! Car Model already registered.", 'danger');
            // }

            $query = "INSERT INTO `vehicles`(`registration_number`, `model`, `capacity`)
             VALUES ('$this->reg_number','$this->model','$this->capacity')";
            $result = $this->db->insert($query);
            if ($result) {
                return $this->alertMessage("Success! New Vehicle Added.", 'success');
            } else {
                return $this->alertMessage("Error: " . $result->error, 'danger');
            }
        }
    }

    private function isRegistrationNumberUnique($regNumber)
    {
        $query = "SELECT * FROM vehicles WHERE registration_number = '$regNumber'";
        $result = $this->db->select($query);
        if ($result) {
            return true;
        }
    }

    private function isRegistrationNumberUniqueOrNot($regNumber, $vid)
    {
        $query = "SELECT * FROM vehicles WHERE registration_number = '$regNumber' AND vehicle_id != '$vid'";
        $result = $this->db->select($query);
        if ($result) {
            return true;
        }
    }

    // private function isModelUnique($model) {
    //     $query = "SELECT * FROM vehicles WHERE model = '$model'";
    //     $result = $this->db->select($query);
    //     if ($result) {
    //         return true;
    //     }
    // }

    function allVehicles()
    {
        $query = "select * from vehicles";
        $result = $this->db->select($query);
        return $result;
    }
    function allTrips()
    {
        $query = "SELECT
        t.trip_id,
        t.vehicle_id,
        t.driver_id,
        CONCAT(v.registration_number, ' (', v.model, ')') AS vehicle_details,
        CONCAT(d.name) AS driver_details,
        t.start_point,
        t.destination,
        t.distance_covered,
        t.charges,
        t.date,
        t.time
    FROM
        trips t
    JOIN
        vehicles v ON t.vehicle_id = v.vehicle_id
    JOIN
        drivers d ON t.driver_id = d.driver_id;";
        $result = $this->db->select($query);
        return $result;
    }

    function allDrivers()
    {
        $query = "select * from drivers";
        $result = $this->db->select($query);
        return $result;
    }

    function deleteVehicles($vehicle_id)
    {
        $query = "DELETE FROM `vehicles` WHERE `vehicle_id` = '$vehicle_id'";
        $result = $this->db->delete($query);
        if ($result) {
            return $this->alertMessage("Success! Vehicle Deleted Successfully.", 'success');
        } else {
            return $this->alertMessage("Error: " . $result->error, 'danger');
        }
    }

    function deleteTrip($trip_id)
    {
        $trip_id = $this->db->link->real_escape_string($trip_id);

        $query = "DELETE FROM trips WHERE trip_id = $trip_id";
        $result = $this->db->delete($query);
        if ($result) {
            return $this->alertMessage("Success! Trip Deleted Successfully.", 'success');
        } else {
            return $this->alertMessage("Error: " . $result->error, 'danger');
        }
    }

    function deleteDriver($driver_id)
    {
        $query = "DELETE FROM `drivers` WHERE `driver_id` = '$driver_id'";
        $result = $this->db->delete($query);
        if ($result) {
            return $this->alertMessage("Success! Driver Deleted Successfully.", 'success');
        } else {
            return $this->alertMessage("Error: " . $result->error, 'danger');
        }
    }

    function fetchDetails($vehicle_id)
    {
        $query = "SELECT * FROM vehicles WHERE vehicle_id = '$vehicle_id'";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            $this->reg_number = $this->db->link->real_escape_string(trim($row['registration_number']));
            $this->model = $this->db->link->real_escape_string(trim(ucwords($row['model'])));
            $this->capacity = $this->db->link->real_escape_string(trim($row['capacity']));
        } else {
            // Handle the case where no vehicles are registered
            return 0;
        }
    }

    function fetchDetailsForDriver($driver_id)
    {
        $query = "SELECT * FROM drivers WHERE driver_id = '$driver_id'";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            $this->name = $this->db->link->real_escape_string(trim($row['name']));
            $this->contact = $this->db->link->real_escape_string(trim(ucwords($row['contact'])));
            $this->cnic = $this->db->link->real_escape_string(trim($row['cnic']));
            $this->license_number = $this->db->link->real_escape_string(trim($row['license_number']));
        } else {
            // Handle the case where no vehicles are registered
            return 0;
        }
    }

    function fetchDetailsForTrip($trip_id)
    {
        $query = "SELECT * FROM trips WHERE trip_id = '$trip_id'";
        $result = $this->db->select($query);

        if ($result) {
            $row = $result->fetch_assoc();
            $this->driver_id = $row['driver_id'];
            $this->vehicle_id = $row['vehicle_id'];
            $this->start_point = $this->db->link->real_escape_string(trim($row['start_point']));
            $this->destination = $this->db->link->real_escape_string(trim($row['destination']));
            $this->distance_covered = $this->db->link->real_escape_string(trim($row['distance_covered']));
            $this->charges = $this->db->link->real_escape_string(trim($row['charges']));
            $this->date = $this->db->link->real_escape_string(trim($row['date']));
            $this->time = $this->db->link->real_escape_string(trim($row['time']));
        } else {
            // Handle the case where no trip is found with the given ID
            return 0;
        }
    }


    function editDetails($data, $vehicle_id)
    {
        if (isset($data['edit_vehicle']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->reg_number = $this->db->link->real_escape_string(trim($data['registrationNumber']));
            $this->model = $this->db->link->real_escape_string(trim(ucwords($data['model'])));
            $this->capacity = $this->db->link->real_escape_string(trim($data['capacity']));
            if (empty($this->reg_number and $this->model and $this->capacity)) {
                return $this->alertMessage("All fields are required.", 'danger');
            }
            // Validate Vehicle Number
            if (!preg_match("/^[A-Z]{1,3}-[0-9]{1,4}(?:-[0-9]{1,2})?$/", $this->reg_number)) {
                return $this->alertMessage("Invalid Registration Number <br>. <ol><li>Start with one to three uppercase letters</li><li>A hyphen is used to separate the letters and numbers.</li><li>Match one to four digits (mandatory part)</li><li>An additional hyphen followed by one or two digits for the year of registration. (Optional)</li><li><b>Example: ABC-1234 OR ABC-1234-11</b></li>", 'danger');
            }
            // Validate Model
            if (!preg_match("/^[a-zA-Z][a-zA-Z0-9_\s-]*$/", $this->model)) {
                return $this->alertMessage("Invalid Car Model - <br> Car Model should start and end with one or more lowercase or uppercase letters, digits, underscores, hyphens, or white spaces.", 'danger');
            }
            // Check existence of Registration Number
            if ($this->isRegistrationNumberUniqueOrNot($this->reg_number, $vehicle_id) == true) {
                return $this->alertMessage("Error! Car Registration Number already registered.", 'danger');
            }

            // Check existence of Model
            // if ($this->isModelUnique($this->model) == true) {
            //     return $this->alertMessage("Error! Car Model already registered.", 'danger');
            // }

            $query = "UPDATE `vehicles` SET `registration_number`='$this->reg_number',`model`='$this->model',`capacity`='$this->capacity' WHERE `vehicle_id` = '$vehicle_id'";
            $result = $this->db->update($query);
            if ($result) {
                return $this->alertMessage("Success! Vehicle Update Successfully.", 'success');
            } else {
                return $this->alertMessage("Error: " . $result->error, 'danger');
            }
        }
    }

    function addDriver($data)
    {
        if (isset($data['add_driver']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->name = $this->db->link->real_escape_string(trim($data['name']));
            $this->contact = $this->db->link->real_escape_string(trim(ucwords($data['contact'])));
            $this->cnic = $this->db->link->real_escape_string(trim($data['cnic']));
            $this->license_number = $this->db->link->real_escape_string(trim($data['license_number']));
            if (empty($this->name and $this->contact and $this->cnic and $this->license_number)) {
                return $this->alertMessage("All fields are required.", 'danger');
            }
            // Validate Vehicle Number
            if (!preg_match("/^[a-zA-Z\s]+$/", $this->name)) {
                return $this->alertMessage("Invalid Name <br>. <ol><li>Name contains white space and alphabets only", 'danger');
            }
            // Validate Contact Number
            if (!preg_match("/^(?:\+92|03)\d{9,10}$/", $this->contact)) {
                return $this->alertMessage("Invalid Contact Number - <br> Must of Format of <br> <ol><li>+92XXXXXXXXXX</li><li>03XXXXXXXXX</li></ol>", 'danger');
            }
            // Validate Contact Number
            if (!preg_match("/^[0-9]{5}[0-9]{7}[0-9]$/", $this->cnic)) {
                return $this->alertMessage("Invalid CNIC Number - <br> CNIC Number contains only digits (without dashes).", 'danger');
            }
            // Validate License Number
            if (!preg_match("/^[A-Z\d_\s-]+$/", $this->license_number)) {
                return $this->alertMessage("Invalid License Number - <br> License Number contains only Alphabets, Digists, White space, dashes & underscore only.", 'danger');
            }
            // Check existence of Registration Number
            if ($this->isDriverUnique() == true) {
                return $this->alertMessage("Error! Driver already registered against Contact Number  / CNIC / License Number.", 'danger');
            }

            $query = "INSERT INTO `drivers`(`name`, `contact`, `cnic`, `license_number`)
             VALUES ('$this->name','$this->contact','$this->cnic','$this->license_number')";
            $result = $this->db->insert($query);
            if ($result) {
                return $this->alertMessage("Success! New Driver Added.", 'success');
            } else {
                return $this->alertMessage("Error: " . $result->error, 'danger');
            }
        }
    }

    public function isDriverUnique()
    {
        $query = "SELECT * FROM drivers WHERE contact= '$this->contact' OR cnic = '$this->cnic' OR license_number = '$this->license_number'";
        $result = $this->db->select($query);
        if ($result) {
            return true;
        }
    }

    function editDetailsofDriver($data, $driver_id)
    {
        if (isset($data['edit_driver']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->name = $this->db->link->real_escape_string(trim($data['name']));
            $this->contact = $this->db->link->real_escape_string(trim(ucwords($data['contact'])));
            $this->cnic = $this->db->link->real_escape_string(trim($data['cnic']));
            $this->license_number = $this->db->link->real_escape_string(trim($data['license_number']));
            if (empty($this->name and $this->contact and $this->cnic and $this->license_number)) {
                return $this->alertMessage("All fields are required.", 'danger');
            }
            // Validate Vehicle Number
            if (!preg_match("/^[a-zA-Z\s]+$/", $this->name)) {
                return $this->alertMessage("Invalid Name <br>. <ol><li>Name contains white space and alphabets only", 'danger');
            }
            // Validate Contact Number
            if (!preg_match("/^(?:\+92|03)\d{9,10}$/", $this->contact)) {
                return $this->alertMessage("Invalid Contact Number - <br> Must of Format of <br> <ol><li>+92XXXXXXXXXX</li><li>03XXXXXXXXX</li></ol>", 'danger');
            }
            // Validate Contact Number
            if (!preg_match("/^[0-9]{5}[0-9]{7}[0-9]$/", $this->cnic)) {
                return $this->alertMessage("Invalid CNIC Number - <br> CNIC Number contains only digits (without dashes).", 'danger');
            }
            // Validate License Number
            if (!preg_match("/^[A-Z\d_\s-]+$/", $this->license_number)) {
                return $this->alertMessage("Invalid License Number - <br> License Number contains only Alphabets, Digists, White space, dashes & underscore only.", 'danger');
            }
            // Check existence of Registration Number
            if ($this->isDriverUniqueForUpdate($driver_id) == true) {
                return $this->alertMessage("Error! Driver already registered against Contact Number  / CNIC / License Number.", 'danger');
            }

            $query = "UPDATE `drivers` SET `name`='$this->name',`contact`='$this->contact',`cnic`='$this->cnic',`license_number`='$this->license_number' WHERE `driver_id` = '$driver_id'";
            $result = $this->db->update($query);
            if ($result) {
                return $this->alertMessage("Success! Driver Updated Successfully.", 'success');
            } else {
                return $this->alertMessage("Error: " . $result->error, 'danger');
            }
        }
    }

    public function isDriverUniqueForUpdate($driver_id)
    {
        $query = "SELECT * FROM drivers WHERE (contact= '$this->contact' OR cnic = '$this->cnic' OR license_number = '$this->license_number') AND driver_id != '$driver_id'";
        $result = $this->db->select($query);
        if ($result) {
            return true;
        }
    }

    function fetchDriversDetails()
    {
        // Fetch drivers from the database
        $drivers_query = "SELECT * FROM drivers";
        $freight_logistics_list = $this->db->select($drivers_query);

        $drivers = [];
        while ($row = mysqli_fetch_assoc($freight_logistics_list)) {
            $drivers[] = $row;
        }
        return $drivers;
    }

    function fetchVehicleDetails()
    {
        // Fetch vehicles from the database
        $vehicles_query = "SELECT * FROM vehicles";
        $vehicles_result = $this->db->select($vehicles_query);

        $vehicles = [];
        while ($row = mysqli_fetch_assoc($vehicles_result)) {
            $vehicles[] = $row;
        }
        return $vehicles;
    }

    function addTrip($data)
    {
        if (isset($data['add_trip']) and $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input data
            $this->driver_id              = $this->db->link->real_escape_string(trim($data['driver_id']));
            $this->vehicle_id             = $this->db->link->real_escape_string(trim($data['vehicle_id']));
            $this->start_point            = $this->db->link->real_escape_string(trim($data['start_point']));
            $this->destination            = $this->db->link->real_escape_string(trim($data['destination']));
            $this->distance_covered       = $this->db->link->real_escape_string(trim($data['distance_covered']));
            $this->date                   = $this->db->link->real_escape_string(trim($data['date']));
            $this->time                   = $this->db->link->real_escape_string(trim($data['time']));
            $this->charges                = $this->db->link->real_escape_string(trim($data['charges']));

            if (empty($this->driver_id and $this->vehicle_id and $this->start_point and $this->destination and $this->distance_covered
                and $this->date and $this->charges)) {
                return $this->alertMessage("Error! All fields must be filled out.", 'danger');
            }

            if (!preg_match("/^[\sA-Za-z0-9_-]+$/", $this->start_point)) {
                return $this->alertMessage("Invalid Start Point. Contains only White Space, Small/Capital letters, underscore and dash only.", 'danger');
            }

            if (!preg_match("/^[\sA-Za-z0-9_-]+$/", $this->destination)) {
                return $this->alertMessage("Invalid Destination. Contains only White Space, Small/Capital letters, underscore and dash only.", 'danger');
            }

            if (!preg_match("/^\d+(\.\d+)?\s*km$/", strtolower($this->distance_covered))) {
                return $this->alertMessage("Invalid Distance Covered. Contains only White space, whole/numeric digits and <b>km</b> is must.", 'danger');
            }

            if (!preg_match("/^\d+(\.\d+)?$/", strtolower($this->charges))) {
                return $this->alertMessage("Invalid Charges. Contains only  whole/numeric digits.", 'danger');
            }

            $checkDriverQuery = "SELECT * FROM trips WHERE driver_id = '$this->driver_id' AND date = '$this->date' AND time = '$this->time'";
            $checkDriverResult = $this->db->select($checkDriverQuery);

            // Check if the same vehicle is scheduled within the same time and date
            $checkVehicleQuery = "SELECT * FROM trips WHERE vehicle_id = '$this->vehicle_id' AND date = '$this->date' AND time = '$this->time'";
            $checkVehicleResult = $this->db->select($checkVehicleQuery);

            if ($checkDriverResult) {
                // Driver already scheduled for the same time and date
                return $this->alertMessage("Error: Driver is already scheduled for the same time or date.", 'danger');
            }

            if ($checkVehicleResult) {
                // Vehicle already scheduled for the same time and date
                return $this->alertMessage("Error: Vehicle is already scheduled for the same time or date.", 'danger');
            }

            // Validate Date
            $currentTimestamp = time();
            $inputTimestamp = strtotime($this->date . ' ' . $this->time);

            if ($inputTimestamp < $currentTimestamp) {
                return $this->alertMessage("Error: The selected date and time must be current or future.", 'danger');
            }

            // Insert the new trip into the database
            $query = "INSERT INTO trips (driver_id, vehicle_id, start_point, destination, distance_covered, charges, date, time) 
                      VALUES ('$this->driver_id', '$this->vehicle_id', '$this->start_point', '$this->destination', '$this->distance_covered', '$this->charges', '$this->date', '$this->time')";

            // Execute the query (use your database connection method here)
            $result = $this->db->insert($query);

            if ($result) {
                // Trip added successfully
                return $this->alertMessage("Success: Trip added successfully.", 'success');
?>
                <script>
                    setTimeout(function() {
                        window.location.href = "add_trip.php";
                    }, 1000);
                </script>
            <?php
                exit;
            } else {
                // Handle error, e.g., display an error message
                echo "Error: " . mysqli_error($this->db->link);
            }
        }
    }

    // Function to get vehicle details
    function getVehicleDetails($vehicleId)
    {

        $vehicleId = $this->db->link->real_escape_string($vehicleId);

        $query = "SELECT * FROM vehicles WHERE vehicle_id = $vehicleId";
        $result = $this->db->select($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row;
        }

        return null;
    }

    // Function to get driver details
    function getDriverDetails($driverId)
    {

        $driverId = $this->db->link->real_escape_string($driverId);

        $query = "SELECT * FROM drivers WHERE driver_id = $driverId";
        $result = $this->db->select($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row;
        }

        return null;
    }

    function editDetailsofTrip($data, $trip_id)
    {
        if (isset($data['edit_trip']) and $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input data
            $this->driver_id              = $this->db->link->real_escape_string(trim($data['driver_id']));
            $this->vehicle_id             = $this->db->link->real_escape_string(trim($data['vehicle_id']));
            $this->start_point            = $this->db->link->real_escape_string(trim($data['start_point']));
            $this->destination            = $this->db->link->real_escape_string(trim($data['destination']));
            $this->distance_covered       = $this->db->link->real_escape_string(trim($data['distance_covered']));
            $this->date                   = $this->db->link->real_escape_string(trim($data['date']));
            $this->time                   = $this->db->link->real_escape_string(trim($data['time']));
            $this->charges                = $this->db->link->real_escape_string(trim($data['charges']));

            if (empty($this->driver_id and $this->vehicle_id and $this->start_point and $this->destination and $this->distance_covered
                and $this->date and $this->charges)) {
                return $this->alertMessage("Error! All fields must be filled out.", 'danger');
            }

            if (!preg_match("/^[\sA-Za-z0-9_-]+$/", $this->start_point)) {
                return $this->alertMessage("Invalid Start Point. Contains only White Space, Small/Capital letters, underscore and dash only.", 'danger');
            }

            if (!preg_match("/^[\sA-Za-z0-9_-]+$/", $this->destination)) {
                return $this->alertMessage("Invalid Destination. Contains only White Space, Small/Capital letters, underscore and dash only.", 'danger');
            }

            if (!preg_match("/^\d+(\.\d+)?\s*km$/", strtolower($this->distance_covered))) {
                return $this->alertMessage("Invalid Distance Covered. Contains only White space, whole/numeric digits and <b>km</b> is must.", 'danger');
            }

            if (!preg_match("/^\d+(\.\d+)?$/", strtolower($this->charges))) {
                return $this->alertMessage("Invalid Charges. Contains only  whole/numeric digits.", 'danger');
            }

            $checkDriverQuery = "SELECT * FROM trips WHERE driver_id = '$this->driver_id' AND date = '$this->date' AND time = '$this->time' AND trip_id != '$trip_id'";
            $checkDriverResult = $this->db->select($checkDriverQuery);

            // Check if the same vehicle is scheduled within the same time and date
            $checkVehicleQuery = "SELECT * FROM trips WHERE vehicle_id = '$this->vehicle_id' AND date = '$this->date' AND time = '$this->time' AND trip_id != '$trip_id'";
            $checkVehicleResult = $this->db->select($checkVehicleQuery);

            if ($checkDriverResult) {
                // Driver already scheduled for the same time and date
                return $this->alertMessage("Error: Driver is already scheduled for the same time or date.", 'danger');
            }

            if ($checkVehicleResult) {
                // Vehicle already scheduled for the same time and date
                return $this->alertMessage("Error: Vehicle is already scheduled for the same time or date.", 'danger');
            }

            // Validate Date
            $currentTimestamp = time();
            $inputTimestamp = strtotime($this->date . ' ' . $this->time);

            if ($inputTimestamp < $currentTimestamp) {
                return $this->alertMessage("Error: The selected date and time must be current or future.", 'danger');
            }

            // Insert the new trip into the database

            $query = "UPDATE trips SET 
            driver_id = '$this->driver_id',
            vehicle_id = '$this->vehicle_id',
            start_point = '$this->start_point',
            destination = '$this->destination',
            distance_covered = '$this->distance_covered',
            charges = '$this->charges',
            date = '$this->date',
            time = '$this->time'
            WHERE trip_id = '$trip_id'";
            // Execute the query (use your database connection method here)
            $result = $this->db->update($query);

            if ($result) {
                // Trip added successfully
                return $this->alertMessage("Success: Trip updated successfully.", 'success');
            ?>
                <script>
                    setTimeout(function() {
                        window.location.href = "trip_list.php";
                    }, 1000);
                </script>
            <?php
                exit;
            } else {
                // Handle error, e.g., display an error message
                echo "Error: " . mysqli_error($this->db->link);
            }
        }
    }

    function fetchAllExpensesTypes()
    {
        $query = "select * from expense_type";
        $result = $this->db->select($query);
        return $result;
    }

    function addNewExpense($data)
    {
        if (isset($data['add_expense']) and $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->type                     = $this->db->link->real_escape_string(trim($data['expenseTypeDropdown']));
            $this->amount                   = $this->db->link->real_escape_string(trim($data['amount']));
            $this->description              = $this->db->link->real_escape_string(trim($data['description']));
            if (empty($this->type and $this->amount and $this->description)) {
                return $this->alertMessage("Error: All fields must be filled out.", 'danger');
            }

            // Validate Amount
            if (!preg_match("/^\d+(\.\d+)?$/", $this->amount)) {
                return $this->alertMessage("Invalid amount. Any numeric value (integer or decimal) is allowed only.", 'danger');
            }

            // Validate description
            if (!preg_match("/^[a-zA-Z0-9\s_\-]+$/", $this->description)) {
                return $this->alertMessage("Invalid description. Allow only contains only numeric values, alphabets, white space, underscore, and hyphen.", 'danger');
            }

            $query = "INSERT INTO `expenses`(`type`, `amount`, `description`) 
            VALUES ('$this->type','$this->amount','$this->description')";
            $result = $this->db->insert($query);
            if ($result) {
                return $this->alertMessage("Expense addedd successfully.", 'success');
            }
        }
    }

    function allExpenses()
    {
        $query = "SELECT expenses.expense_id, expense_type.type_name, expenses.amount, expenses.description, expenses.date_added
                FROM expenses
                INNER JOIN expense_type ON expenses.type = expense_type.id";
        $result = $this->db->select($query);
        return $result;
    }

    function deleteExpense($expense_id)
    {
        $query = "DELETE FROM `expenses` WHERE `expense_id` = '$expense_id'";
        $result = $this->db->delete($query);
        if ($result) {
            return $this->alertMessage("Success! Expense Deleted Successfully.", 'success');
        } else {
            return $this->alertMessage("Error: " . $this->db->error, 'danger');
        }
    }

    public function fetchExpenseDetails($expense_id)
    {
        // Assuming $this->db is an instance of mysqli
        $query = "SELECT * FROM expenses WHERE expense_id = '$expense_id'";
        $result = $this->db->select($query);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return null; // Expense not found
        }
    }
    public function fetchIncomeDetailsForUpdate($income_id)
    {
        // Assuming $this->db is an instance of mysqli
        $query = "SELECT * FROM income WHERE income_id = '$income_id'";
        $result = $this->db->select($query);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return null; // Expense not found
        }
    }

    function udpateExpense($data, $id)
    {
        if (isset($data['update_expense']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $expense_id = isset($id['expense_id']) ? $id['expense_id'] : null;
            if (!$expense_id) {
                return $this->alertMessage("Error: Expense ID is missing.", 'danger');
            }

            $this->type = $this->db->link->real_escape_string(trim($data['expenseTypeDropdown']));
            $this->amount = $this->db->link->real_escape_string(trim($data['amount']));
            $this->description = $this->db->link->real_escape_string(trim($data['description']));

            // Validate if all fields are filled out
            if (empty($this->type) || empty($this->amount) || empty($this->description)) {
                return $this->alertMessage("Error: All fields must be filled out.", 'danger');
            }

            // Validate Amount
            if (!preg_match("/^\d+(\.\d+)?$/", $this->amount)) {
                return $this->alertMessage("Invalid amount. Only numeric values (integer or decimal) are allowed.", 'danger');
            }

            // Validate description
            if (!preg_match("/^[a-zA-Z0-9\s_\-]+$/", $this->description)) {
                return $this->alertMessage("Invalid description. Only alphanumeric characters, white space, underscore, and hyphen are allowed.", 'danger');
            }

            // Update expense in the database
            $query = "UPDATE `expenses` SET `type`='$this->type', `amount`='$this->amount', `description`='$this->description' WHERE `expense_id`='$expense_id'";
            $result = $this->db->update($query);
            if ($result) {
                return $this->alertMessage("Expense updated successfully.", 'success');
            } else {
                return $this->alertMessage("Error updating expense.", 'danger');
            }
        }
    }

    function allIncomes()
    {
        $query = "SELECT income.income_id, income.type, expense_type.type_name, income.amount, income.description, income.date_added
        FROM income
        LEFT JOIN expense_type ON income.type = expense_type.id";
        $result = $this->db->select($query);
        return $result;
    }

    function addNewIncome($data)
    {
        if (isset($data['add_income']) and $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->type                     = $this->db->link->real_escape_string(trim($data['incomeTypeDropdown']));
            $this->amount                   = $this->db->link->real_escape_string(trim($data['amount']));
            $this->description              = $this->db->link->real_escape_string(trim($data['description']));
            if (empty($this->type and $this->amount and $this->description)) {
                return $this->alertMessage("Error: All fields must be filled out.", 'danger');
            }

            // Validate Amount
            if (!preg_match("/^\d+(\.\d+)?$/", $this->amount)) {
                return $this->alertMessage("Invalid amount. Any numeric value (integer or decimal) is allowed only.", 'danger');
            }

            // Validate description
            if (!preg_match("/^[a-zA-Z0-9\s_\-]+$/", $this->description)) {
                return $this->alertMessage("Invalid description. Allow only contains only numeric values, alphabets, white space, underscore, and hyphen.", 'danger');
            }

            $query = "INSERT INTO `income`(`type`, `amount`, `description`) 
            VALUES ('$this->type','$this->amount','$this->description')";
            $result = $this->db->insert($query);
            if ($result) {
                return $this->alertMessage("Income addedd successfully.", 'success');
            }
        }
    }

    function deleteIncome($income_id)
    {
        $query = "DELETE FROM `income` WHERE `income_id` = '$income_id'";
        $result = $this->db->delete($query);
        if ($result) {
            return $this->alertMessage("Success! Income Deleted Successfully.", 'success');
        } else {
            return $this->alertMessage("Error: " . $this->db->error, 'danger');
        }
    }

    function udpateIncome($data, $id)
    {
        if (isset($data['update_income']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $income_id = isset($id['income_id']) ? $id['income_id'] : null;
            if (!$income_id) {
                return $this->alertMessage("Error: Income ID is missing.", 'danger');
            }

            $this->type = $this->db->link->real_escape_string(trim($data['incomeTypeDropdown']));
            $this->amount = $this->db->link->real_escape_string(trim($data['amount']));
            $this->description = trim($data['description']);

            // Validate if all fields are filled out
            if (empty($this->type) || empty($this->amount) || empty($this->description)) {
                return $this->alertMessage("Error: All fields must be filled out.", 'danger');
            }

            // Validate Amount
            if (!preg_match("/^\d+(\.\d+)?$/", $this->amount)) {
                return $this->alertMessage("Invalid amount. Only numeric values (integer or decimal) are allowed.", 'danger');
            }

            // Validate description
            if (!preg_match("/^[a-zA-Z0-9\s_\-\.]+$/", $this->description)) {
                return $this->alertMessage("Invalid description. Only alphanumeric characters, white space, underscore, and hyphen are allowed.", 'danger');
            }

            // Update income in the database
            $query = "UPDATE `income` SET `type`='$this->type', `amount`='$this->amount', `description`='$this->description' WHERE `income_id`='$income_id'";
            $result = $this->db->update($query);
            if ($result) {
                return $this->alertMessage("Income updated successfully.", 'success');
            } else {
                return $this->alertMessage("Error updating income.", 'danger');
            }
        }
    }

    public function GenerateReport($data)
    {
        if (isset($data['generate_report']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $start_date = $data['start_date'];
            $end_date = $data['end_date'];
            $generated_type = $data['generation_type'];

            // Check if there are any matching income entries within the specified dates
            $income_check_query = "SELECT COUNT(*) AS count FROM income WHERE date_added BETWEEN '$start_date' AND '$end_date'";
            $income_check_result = $this->db->select($income_check_query);
            $income_check_row = $income_check_result->fetch_assoc();
            $income_count = $income_check_row['count'];

            // Check if there are any matching expense entries within the specified dates
            $expense_check_query = "SELECT COUNT(*) AS count FROM expenses WHERE date_added BETWEEN '$start_date' AND '$end_date'";
            $expense_check_result = $this->db->select($expense_check_query);
            $expense_check_row = $expense_check_result->fetch_assoc();
            $expense_count = $expense_check_row['count'];

            if ($income_count > 0 && $expense_count > 0) {
                // Query to calculate total income for the given period
                $income_query = "SELECT SUM(amount) AS total_income FROM income WHERE date_added BETWEEN '$start_date' AND '$end_date'";
                $income_result = $this->db->select($income_query);
                $income_row = $income_result->fetch_assoc();
                $total_income = $income_row['total_income'];

                // Query to calculate total expenses for the given period
                $expense_query = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE date_added BETWEEN '$start_date' AND '$end_date'";
                $expense_result = $this->db->select($expense_query);
                $expense_row = $expense_result->fetch_assoc();
                $total_expenses = $expense_row['total_expenses'];

                // Calculate net income
                $net_income = $total_income - $total_expenses;

                // Insert data into reports table
                $insert_query = "INSERT INTO reports (start_date, end_date, total_income, total_expenses, net_income, generated_type) VALUES ('$start_date', '$end_date', '$total_income', '$total_expenses', '$net_income', '$generated_type')";
                if ($this->db->insert($insert_query)) {
                    $_SESSION['report_generated'] = true; // Set session variable to true indicating report is generated
                    return $this->alertMessage("Report generated successfully.", 'success');
                } else {
                    return $this->alertMessage("Error. " . $insert_query . "<br>" . mysqli_error($this->db->link), 'danger');
                }
            } else {
                return $this->alertMessage("No income or expense data found between the specified dates.", 'danger');
            }
        }
    }

    public function ShowGeneratedReport()
    {
        if (isset($_SESSION['report_generated']) && $_SESSION['report_generated'] === true) {
            // Query to fetch the most recent report data
            $report_query = "SELECT * FROM reports ORDER BY report_id DESC LIMIT 1";
            $report_result = $this->db->select($report_query);
            $report_row = $report_result->fetch_assoc();

            // Display the report data in tabular format
            if ($report_row) {
                echo "<h2>Generated Report</h2>";
                echo "<table class='table'>";
                echo "<thead><tr><th>Start Date</th><th>End Date</th><th>Total Income</th><th>Total Expenses</th><th>Net Income</th><th>Generated Type</th></tr></thead>";
                echo "<tbody>";
                echo "<tr>";
                echo "<td>" . $report_row['start_date'] . "</td>";
                echo "<td>" . $report_row['end_date'] . "</td>";
                echo "<td>" . $report_row['total_income'] . " Pkr</td>";
                echo "<td>" . $report_row['total_expenses'] . " Pkr</td>";
                echo "<td>" . $report_row['net_income'] . " Pkr</td>";
                echo "<td>" . $report_row['generated_type'] . "</td>";
                echo "</tr>";
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No reports available.</p>";
            }

            // Clear the session variable
            unset($_SESSION['report_generated']);
        } else {
            // Buffer output to prevent header already sent warning
            // Script to redirect to another page if no report is generated
            //   echo "<script>window.location.href = 'report_generation.php';</script>";
        }
    }


    // PHP function to retrieve all monthly generated reports
    public function AllMonthlyGeneratedReports()
    {
        $query = "SELECT * FROM reports WHERE generated_type = '' ORDER BY report_id DESC";
        $result = $this->db->select($query);
        $reports = array();
        while ($row = $result->fetch_assoc()) {
            $reports[] = $row;
        }
        return $reports;
    }

    // PHP function to retrieve all on-demand generated reports
    public function AllOnDemandGeneratedReports()
    {
        $query = "SELECT * FROM reports WHERE generated_type = 'On Demand' ORDER BY report_id DESC";
        $result = $this->db->select($query);
        $reports = array();
        while ($row = $result->fetch_assoc()) {
            $reports[] = $row;
        }
        return $reports;
    }

    function fetchFrightLogisticsDetails()
    {
        // Fetch drivers from the database
        $freight_logistics = "SELECT * FROM `freight_logistics`";
        $freight_logistics_list = $this->db->select($freight_logistics);

        $list = [];
        while ($row = mysqli_fetch_assoc($freight_logistics_list)) {
            $list[] = $row;
        }
        return $list;
    }

    function addFrightAndLogistics($data)
    {
        if (isset($data['add_details']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input data
            $this->freight_details = $this->db->link->real_escape_string(trim($data['freight_details']));
            $this->logistics_details = $this->db->link->real_escape_string(trim($data['logistics_details']));
            $this->booking_date = $this->db->link->real_escape_string(trim($data['booking_date']));
            $this->shipment_date = $this->db->link->real_escape_string(trim($data['shipment_date']));
            $this->price = $this->db->link->real_escape_string(trim($data['price']));

            if (empty($this->freight_details) || empty($this->logistics_details) || empty($this->price)) {
                return $this->alertMessage("Error! All fields must be filled out.", 'danger');
            }

            // Insert the new freight and logistics details into the database
            $query = "INSERT INTO freight_logistics (freight_details, logistics_details, price, booking_date, shipment_date) 
                      VALUES ('$this->freight_details', '$this->logistics_details', '$this->price', '$this->booking_date', '$this->shipment_date')";

            // Execute the query (use your database connection method here)
            $result = $this->db->insert($query);

            if ($result) {
                // Freight and logistics details added successfully
                return $this->alertMessage("Success: Freight and logistics details added successfully.", 'success');
            ?>
                <script>
                    setTimeout(function() {
                        window.location.href = "logistics_list.php";
                    }, 1000);
                </script>
<?php
                exit;
            } else {
                // Handle error, e.g., display an error message
                echo "Error: " . mysqli_error($this->db->link);
            }
        }
    }

    function deleteFrightAndLogistics($id)
    {
        $query = "DELETE FROM `freight_logistics` WHERE `id` = '$id'";
        $result = $this->db->delete($query);
        if ($result) {
            return $this->alertMessage("Success! Record Deleted Successfully.", 'success');
        } else {
            return $this->alertMessage("Error: " . $result->error, 'danger');
        }
    }

    function fetchLogistics($id)
    {
        $query = "SELECT * FROM freight_logistics WHERE id = '$id'";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            $this->freight_details = $this->db->link->real_escape_string(trim($row['freight_details']));
            $this->logistics_details = $this->db->link->real_escape_string(trim($row['logistics_details']));
            $this->price = $this->db->link->real_escape_string(trim($row['price']));
            $this->booking_date = $this->db->link->real_escape_string(trim($row['booking_date']));
            $this->shipment_date = $this->db->link->real_escape_string(trim($row['shipment_date']));
        } else {
            // Handle the case where no record is found
            return 0;
        }
    }

    function editLogistics($data, $id)
    {
        if (isset($data['edit_logistics']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->freight_details = $this->db->link->real_escape_string(trim($data['freight_details']));
            $this->logistics_details = $this->db->link->real_escape_string(trim($data['logistics_details']));
            $this->price = $this->db->link->real_escape_string(trim($data['price']));
            $this->booking_date = $this->db->link->real_escape_string(trim($data['booking_date']));
            $this->shipment_date = $this->db->link->real_escape_string(trim($data['shipment_date']));

            if (empty($this->freight_details) || empty($this->logistics_details) || empty($this->price) || empty($this->booking_date) || empty($this->shipment_date)) {
                return $this->alertMessage("All fields are required.", 'danger');
            }

            // Update logistics details in the database
            $query = "UPDATE freight_logistics 
                      SET freight_details = '$this->freight_details', 
                          logistics_details = '$this->logistics_details', 
                          price = '$this->price', booking_date = '$this->booking_date', shipment_date = '$this->shipment_date'
                      WHERE id = '$id'";

            $result = $this->db->update($query);

            if ($result) {
                return $this->alertMessage("Success! Logistics details updated successfully.", 'success');
            } else {
                return $this->alertMessage("Error: " . $this->db->link->error, 'danger');
            }
        }
    }

    public function FetchShipmentDetails()
    {
        // Assuming $this->db is your MySQLi database connection object
        $query = "SELECT * FROM payments";
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

    public function confirmShipment($id)
    {
        $query = "UPDATE `payments` SET `status`='Completed' WHERE `id` ='$id'";
        $result = $this->db->update($query);
        if ($result) {
            $this->msg = $this->alertMessage("Success! Data updated successfully.", 'success');
        } else {
            $this->msg = $this->alertMessage("Error: " . $this->db->link->error, 'danger');
        }
    }
    public function updateShipment($id, $data)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $route_details = trim(htmlspecialchars(mysqli_real_escape_string($this->db->link, $data['route'])));
            $query = "UPDATE `payments` SET `current_route`='$route_details' WHERE `id` = '$id'";
            $result = $this->db->update($query);
            if ($result) {
                $this->msg = $this->alertMessage("Success! Data updated successfully.", 'success');
            } else {
                $this->msg = $this->alertMessage("Error: " . $this->db->link->error, 'danger');
            }
        }
    }
}
