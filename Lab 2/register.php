<?php
session_start(); // Starting session

if(!isset($_SESSION['username'])) { // If session is not set then redirect to Login Page
    header("Location: login.php"); // Redirecting to Login Page
    exit(); // Stop script
}
?>

<?php

include "db.php"; //using database connection file here

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $matricno = $_POST['matricno'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $programme = $_POST['programme'];
    $yearstudy = $_POST['yearstudy'];

    // combine the selected subjects into a single string, separated by commas
    if(!empty($_POST['subject'])) {
        $subject = implode(",", $_POST['subject']);
    } else {
        $error_message_atleastone = "You must select at least one subject.";
    }


    $statement = $conn->prepare("INSERT INTO students (name, matricno, email, phone, gender, dob, programme, yearstudy, subject) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $statement->bind_param("sssssssss", $name, $matricno, $email, $phone, $gender, $dob, $programme, $yearstudy, $subject);

    if ($statement->execute()) {
        header("Location: register.php?message=Registration successful!"); // Success message in URL
        exit();
    } else {
        header("Location: register.php?message=Error during registration."); // Error message in URL
        exit();
    }

    $statement->close();
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
    <title>Student Registration</title>

        <style>
            body {
                background-color: rgb(230, 238, 230);
                text-align: center;
                padding: 20px;
            }
            h1 {
                margin-bottom: 30px;
            }
            h3.solid {
                border: 3px solid rgb(196, 208, 245);
                padding: 8px;
                background-color: rgb(196, 208, 245);
            }

        </style>
    </head>
    
    <body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e8dcbf;">
        <div class="container-xxl">
            <a class="navbar-brand" href="#">
                <span class="fw-bold text-secondary"> Student Management System </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end align-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="view.php">List Students</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Add Student</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>

            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

        </div>
    </nav>

    <br>

    <img src="logo_utm.png" alt="This is UTM logo" width="500" height="150" style="display: block; margin: auto;">
    <br>    
    <h1 style="text-align: center;">Add New Student</h1>

        <!-- Display any message passed from URL -->
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-info mt-3" role="alert">
                <?= htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <!-- Display Error Message if set -->
        <?php if (!empty($_GET['error_message_atleastone'])): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?= htmlspecialchars($_GET['error_message_atleastone']); ?>
                    </div>
                <?php endif; ?>

        <div class="container-lg">
            <div class="text-center">

            <div class="row justify-content-center my-5">
            <div class="col-lg-6">
            <div class="bg-white p-4 rounded shadow">

            <form action="register.php" method="POST" class="border p-4 ">
            <h3 class="solid">Student Personal Details</h3>

                <label for="name" class="form-label">Name</label>
                <div class="mb-4 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person-fill"></i>
                    </span>
                <input type="text" name="name" class="form-control" placeholder="e.g. Mario" required>
                </div>
            
                <label for="matricno" class="form-label">Matric No</label>
                <div class="mb-4 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person-vcard-fill"></i>
                    </span>
                <input type="text" name="matricno" class="form-control" placeholder="e.g. A23CS0241" required>
                </div>

                <label for="email" class="form-label">Email</label>
                <div class="mb-4 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope-fill"></i>
                    </span>
                <input type="email" name="email" class="form-control" placeholder="e.g. mario@example.com" required>
                </div>

                <label for="phone" class="form-label">Phone Number</label>
                <div class="mb-4 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-phone-fill"></i>
                    </span>
                <input type="text" name="phone" class="form-control" placeholder="e.g. 0167727876" required>
                </div>

                <label class="form-label">Gender</label><br>
                <div class="mb-4">
                <input type="radio" name="gender" value="Male" required> Male
                <input type="radio" name="gender" value="Female" required> Female<br>
                </div>

                <label for="dob" class="form-label">Date of Birth</label>
                <div class="mb-4 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-calendar2-day-fill"></i>
                    </span>
                <input type="date" name="dob" class="form-control" required>
                </div>

            <h3 class="solid mt-4">Academic Information</h3>

                <label for="programme" class="form-label">Programme of Study</label>
                <div class="mb-4 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-mortarboard-fill"></i>
                    </span>
                <select name="programme" class="form-select" required>
                    <option value="Data Engineering">Data Engineering</option>
                    <option value="Software Engineering">Software Engineering</option>
                    <option value="Network Security">Network Security</option>
                    <option value="Bioinfometrics">Bioinfometrics</option>
                    <option value="Graphic Design">Graphic Design</option>
                </select>
                </div>

                <label for="yearstudy" class="form-label">Year of Study</label>
                <div class="mb-4 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-book-fill"></i>
                    </span>
                <select name="yearstudy" class="form-select" required>
                    <option value="Year 1">Year 1</option>
                    <option value="Year 2">Year 2</option>
                    <option value="Year 3">Year 3</option>
                    <option value="Year 4">Year 4</option>
                </select>
                </div>

            <h3 class="solid mt-4">Subject Selection</h3>

                <input type="checkbox" name="subject[]" value="Digital Logic">
                <label for="subject1">Digital Logic</label><br>
                <input type="checkbox" name="subject[]" value="Discrete Structure">
                <label for="subject2">Discrete Structure</label><br>
                <input type="checkbox" name="subject[]" value="Programming Technique 1">
                <label for="subject3">Programming Technique 1</label><br>
                <input type="checkbox" name="subject[]" value="Programming Technique 2">
                <label for="subject4">Programming Technique 2</label><br>
                <input type="checkbox" name="subject[]" value="Computer Organization Architecture">
                <label for="subject5">Computer Organization Architecture</label><br><br>

            <button type="submit" class="btn btn-success w-50 mb-3">Add Student</button>
            <button type="reset" class="btn btn-danger w-50">Reset</button>
            </form>
            </div>
            </div>
            </div>
        </div>

        <a href="view.php" class="d-block mt-3">View Registered Student List</a>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>

</html>

