<?php
session_start(); // Starting session

if(!isset($_SESSION['username'])) { // If session is not set then redirect to Login Page
    header("Location: login.php"); // Redirecting to Login Page
    exit(); // Stop script
}
?>

<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-info mt-3 text-center" role="alert">
        <?= htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Registered Student List</title>

        <style>
            body {
                background-color: rgb(230, 238, 230);
                margin: 0;
                padding: 20px;
            }

            h1 {
                text-align: center;
                color:black;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px;
            }

            table, th, td {
                border: 1px solid #ccc;
            }

            td {
                padding: 10px;
                text-align: left;
            }

            th {
                background-color: #d3d3d3;
                color:black;
                padding:12px;
                text-align: center;
            }

            .navbar {
            margin-bottom: 20px;
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

    <img src="logo_utm.png" alt="This is UTM logo" width="500" height="150" style="display: block; margin: auto;"><br>
    <br>    
    <h1>Registered Student List</h1>
    <br>
    <div class="container-lg">
        <div class="bg-white p-4 rounded shadow">

        <div class="container">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th> ID </th>
                        <th> Name </th>
                        <th> Matric No </th>
                        <th> Email </th>
                        <th> Phone number </th>
                        <th> Gender </th>
                        <th> Date of Birth </th>
                        <th> Programme of Study </th>
                        <th> Year of Study </th>
                        <th> Subject Selection </th>
                        <th> Update </th>
                        <th> Delete </th>
                    </tr>
                </thead>
                <tbody>
            <?php

            include "db.php"; // using database connection file here

            // prepare the SQL statement
            $statement = $conn->prepare("SELECT * FROM students");
            $statement->execute();
            $result = $statement->get_result();

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>". htmlspecialchars($row['id']) . "</td>";
                    echo "<td>". htmlspecialchars($row['name']) . "</td>";
                    echo "<td>". htmlspecialchars($row['matricno']) . "</td>";
                    echo "<td>". htmlspecialchars($row['email']) . "</td>";
                    echo "<td>". htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>". htmlspecialchars($row['gender']) . "</td>";
                    echo "<td>". htmlspecialchars($row['dob']) . "</td>";
                    echo "<td>". htmlspecialchars($row['programme']) . "</td>";
                    echo "<td>". htmlspecialchars($row['yearstudy']) . "</td>";
                    echo "<td>". htmlspecialchars($row['subject']) . "</td>";
                    echo "<td> <a href='update.php?id=". htmlspecialchars($row['id']) . "' class='btn btn-warning btn-sm'>Update</a></td>";
                    echo "<td> <a href='delete.php?id=". htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='12'> No Data Found </td></tr>";
            }

            $statement->close();
            ?>

                </tbody>
            </table>
        </div>
        </div>
    </div>

        <br>
        <br>

        <div class="container text-center">
            <a href="register.php" class="btn btn-success mb-3">Add New Student</a>
            <a href="logout.php" class="btn btn-secondary mb-3">Logout</a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </body>

</html>