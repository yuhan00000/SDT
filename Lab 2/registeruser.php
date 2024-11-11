<?php
include "db.php"; // Using database connection here

$message = "";
$alert_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if form is submitted
    $username = mysqli_real_escape_string($conn, $_POST['username']); // Get the username value from the form
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Get the password value from the form 

    $sql = "INSERT INTO users_reg (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($conn, $sql)) {
        $message = "Registration successful! You can now <a href='login.php'>login here</a>.";
        $alert_type = 'success';
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        $alert_type = 'danger';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Register</title>

    <style>
        body {
            background-color: #fff0f5;
        }
    </style>

</head>
<body>

<br>
<img src="logo_utm.png" alt="This is UTM logo" width="500" height="150" style="display: block; margin: auto;">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-center mb-4">Register</h2>

                <!-- Display Success or Error Message -->
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $alert_type; ?> mt-3" role="alert">
                        <?= $message; ?>
                    </div>
                <?php endif; ?>

                <!-- Registration Form -->
                <form action="registeruser.php" method="POST" class="border p-4 shadow-sm rounded">
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>

                <!-- Login Link -->
                <div class="text-center mt-3">
                    <a href="login.php">Already have an account? Login here</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

