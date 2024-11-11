<?php
session_start(); // Starting session
include "db.php"; // Using database connection here

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if form is submitted
    $username = mysqli_real_escape_string($conn, $_POST['username']); // Get the username value from the form
    $password = $_POST['password']; // Get the password value from the form 

    $sql = "SELECT * FROM users_reg WHERE username = '$username'"; // Query the database for username
    $result = mysqli_query($conn, $sql); // Run the query

    if (mysqli_num_rows($result) == 1) { // Check if user exists
        $row = mysqli_fetch_assoc($result); // Get the data from the database

        if (password_verify($password, $row['password'])) { // Check if the password matches
            $_SESSION['username'] = $username; // Set the session variable
            header("Location: view.php"); // Redirect to the home page
            exit();
        } else { // If the password doesn't match
            header("Location: login.php?error_message=Invalid username or password."); // Redirect back to login page
            exit();
        }
    } else { // If the user doesn't exist
        header("Location: login.php?error_message=No user found with that username."); // Redirect back to login page
        exit();
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
    <title>Login</title>

    <style>
        body {
            background-color: #FFF7E6;
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
                <h2 class="text-center mb-4">Login</h2>

                <!-- Displaying any message passed in the URL -->
                <?php if (isset($_GET['message'])): ?>
                    <div class="alert alert-info text-center" role="alert">
                        <?= htmlspecialchars($_GET['message']); ?>
                    </div>
                <?php endif; ?>

                <!-- Display Error Message if set -->
                <?php if (!empty($_GET['error_message'])): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?= htmlspecialchars($_GET['error_message']); ?>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form action="login.php" method="POST" class="border p-4 shadow-sm rounded">
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <!-- Register Link -->
                <div class="text-center mt-3">
                    <a href="registeruser.php">Don't have an account? Register here</a>
                </div>
            </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

