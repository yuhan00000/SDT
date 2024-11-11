<?php
session_start(); // Starting session

if(!isset($_SESSION['username'])) { // If session is not set then redirect to Login Page
    header("Location: login.php"); // Redirecting to Login Page
    exit(); // Stop script
}
?>

<?php
        include "db.php"; // using database connection file here
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $matricno = $_POST['matricno'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $gender = $_POST['gender'];
            $dob = $_POST['dob'];
            $programme = $_POST['programme'];
            $yearstudy = $_POST['yearstudy'];
            if(!empty($_POST['subject'])) {
                $subject = implode(",", $_POST['subject']);
            } else {
                $error_message_atleastone = "You must select at least one subject.";
            } // convert array to comma-separated string

            $id = $_GET['id']; // retrieve the id for the update query

            $statement = $conn->prepare("UPDATE students SET name=?, matricno=?, email=?, phone=?, gender=?, dob=?, programme=?, yearstudy=?, subject=?
                     WHERE id=?"); // SQL query to update user data based

            $statement->bind_param("sssssssssi", $name, $matricno, $email, $phone, $gender, $dob, $programme, $yearstudy, $subject, $id);

            if ($statement->execute()) {
                header("Location: view.php?message=Record updated successfully!"); // Success message in URL
                exit();
            } else {
                header("Location: view.php?message=Error during update."); // Error message in URL
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
    <title>Update Student</title>

        <style>
            body{
                background-color: rgb(230, 238, 230);
                text-align: center;
                padding: 20px;
            }

            h1 {
                margin-bottom: 30px;
            }

            h3.solid{
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
    <h1 style="text-align: center;">Update Student</h1>

    <!-- Display any message passed from URL -->
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-info mt-3" role="alert">
            <?= htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Display Error Message if set -->
    <?php if (!empty($error_message_atleastone)): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= htmlspecialchars($error_message_atleastone); ?>
        </div>
    <?php endif; ?>

        <?php

        include "db.php"; // using database connection file here

        if(isset($_GET['id'])){ // Check if id parameter is available inside url
            $id = $_GET['id']; // Get the id parameter value
            $sql = "SELECT * FROM students WHERE id=$id"; // SQL query to select user data based on id
            $result = mysqli_query($conn, $sql); // Execute the query
            $row = mysqli_fetch_assoc($result); // Fetch the result set into an associative array
        }

        ?>

    <div class="container-lg">
        <div class="text-center">

        <div class="row justify-content-center my-5">
        <div class="col-lg-6">
        <div class="bg-white p-4 rounded shadow">

        <form action="update.php?id=<?php echo $row['id']; ?>" method="POST" class="border p-4 shadow-sm rounded">
        <h3 class="solid">Student Personal Details</h3>

            <label for="name" class="form-label">Name</label>
            <div class="mb-4 input-group">
                <span class="input-group-text">
                    <i class="bi bi-person-fill"></i>
                </span>
            <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required><br>
            </div>

            <label for="matricno" class="form-label">Matric No</label>
            <div class="mb-4 input-group">
                <span class="input-group-text">
                    <i class="bi bi-person-vcard-fill"></i>
                </span>
            <input type="text" name="matricno" class="form-control" value="<?php echo $row['matricno']; ?>" required><br>
            </div>

            <label for="email" class="form-label">Email</label>
            <div class="mb-4 input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope-fill"></i>
                </span>
            <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required><br>
            </div>

            <label for="phone" class="form-label">Phone Number</label>
            <div class="mb-4 input-group">
                <span class="input-group-text">
                    <i class="bi bi-phone-fill"></i>
                </span>
            <input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>" required><br>
            </div>

            <label class="form-label">Gender</label><br>
            <div class="mb-4">
            <input type="radio" name="gender" value="Male" <?php if ($row['gender'] == 'Male')echo 'checked'; ?>> Male
            <input type="radio" name="gender" value="Female" <?php if ($row['gender'] == 'Female')echo 'checked'; ?>> Female<br>
            </div>

            <label for="dob" class="form-label">Date of Birth</label>
            <div class="mb-4 input-group">
                <span class="input-group-text">
                    <i class="bi bi-calendar2-day-fill"></i>
                </span>
            <input type="date" name="dob" class="form-control" value="<?php echo $row['dob']; ?>" required><br>
            </div>

            <h3 class="solid mt-4">Academic Information</h3>

            <label for="programme" class="form-label">Programme of Study</label>
            <div class="mb-4 input-group">
                <span class="input-group-text">
                    <i class="bi bi-mortarboard-fill"></i>
                </span>
            <select name="programme" class="form-select" required>
            <option value="Data Engineering" <?php if ($row['programme'] == 'Data Engineering') echo 'selected'; ?>>Data Engineering</option>
            <option value="Software Engineering" <?php if ($row['programme'] == 'Software Engineering') echo 'selected'; ?>>Software Engineering</option>
            <option value="Network Security" <?php if ($row['programme'] == 'Network Security') echo 'selected'; ?>>Network Security</option>
            <option value="Bioinfometrics" <?php if ($row['programme'] == 'Bioinfometrics') echo 'selected'; ?>>Bioinfometrics</option>
            <option value="Graphic Design" <?php if ($row['programme'] == 'Graphic Design') echo 'selected'; ?>>Graphic Design</option>
            </select>
            </div>

            <label for="yearstudy" class="form-label">Year of Study</label>
            <div class="mb-4 input-group">
                <span class="input-group-text">
                    <i class="bi bi-book-fill"></i>
                </span>
            <select name="yearstudy" class="form-select" required>
            <option value="Year 1" <?php if($row['yearstudy'] == 'Year 1') echo 'selected'; ?>>Year 1</option>
            <option value="Year 2" <?php if($row['yearstudy'] == 'Year 2') echo 'selected'; ?>>Year 2</option>
            <option value="Year 3" <?php if($row['yearstudy'] == 'Year 3') echo 'selected'; ?>>Year 3</option>
            <option value="Year 4" <?php if($row['yearstudy'] == 'Year 4') echo 'selected'; ?>>Year 4</option>
            </select>
            </div>

            <h3 class="solid mt-4">Subject Selection</h3>
            
            <?php
            //assuming $row['subject] is a comma-separated string of selected subjects
            $selected_subjects = explode(",", $row['subject']); //convert to array of selected subjects
            
            //list all subjects
            $all_subjects = ["Digital Logic", "Discrete Structure", "Programming Technique 1", "Programming Technique 2", "Computer Organization Architecture"];

            //loop through all subjects to generate checkboxes
            foreach($all_subjects as $subject) {
                //if the subject is in the selected subjects array, mark it as checked
                $checked = in_array($subject, $selected_subjects) ? "checked" : '';
                echo "<div class='form-check'>
                    <input class='form-check-input' type='checkbox' name='subject[]' value='$subject' $checked>
                    <label class='form-check-label'>$subject</label>
                    </div>";
            }

            ?>
            <br>
            <button type="submit" class="btn btn-success w-50 mb-3">Update Student</button>
            <a href="view.php" class="btn btn-secondary w-50 mb-3">Cancel</a>

        </form>
        </div>
        </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </body>
</html>