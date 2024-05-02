<?php
require_once "../classes/Admin.php";
$signUp = new Admin();
$result = $signUp->signUp($_POST);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .gradient-custom {
            background: #6a11cb;
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }

        .custom-container {
            border-radius: 1rem;
        }

        .custom-card {
            border-radius: 1rem;
        }

          /* Left-align headings */
          .form-group label {
            text-align: left;
            display: block;
            /* font-weight: bold; */
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body class="gradient-custom">

    <div class="container py-5 mt-5 custom-container">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white custom-card">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                            <h2 class="fw-bold mb-2 text-uppercase">Admin Registration</h2>

                            <?php 
                            echo $result ?? "";
                            ?>

                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $signUp->name??""?>">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $signUp->address??""?>">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number:</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $signUp->phone??""?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $signUp->email??""?>">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $signUp->password??""?>">
                                </div>
                                <div class="form-group">
                                    <label for="Role">Role:</label>
                                    <input type="text" class="form-control" id="role" name="role" value="<?php echo $signUp->role ??""?>">
                                </div>
                                <button type="submit" name="signup" class="btn btn-outline-light btn-sm px-5">Register</button>
                                <!-- <a href="login.php" class="btn btn-outline-success btn-sm px-5">Login</a> -->
                                <div>
                                    <br><br>
                                <p class="mb-0">Already have an account? <a href="login.php" class="text-white-50 fw-bold">Sign In</a>
                                </p>
                            </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery (optional, for certain Bootstrap features) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
