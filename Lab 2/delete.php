<?php

include "db.php"; // Using database connection file here

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // Check if a confirmation has been made
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Prepare and execute the delete SQL statement
        $statement = $conn->prepare("DELETE FROM students WHERE ID = ?");
        $statement->bind_param("i", $id); //// "i" indicate type integer

        // execute the SQL statement
        if ($statement->execute()) {
            header("Location: view.php?message=User Deleted Successfully");
            exit();
        } else {
            header("Location: view.php?message=User Not Deleted");
            exit();
        }

    // close the prepared statement
        $statement->close();
    }

} else {
        // Redirect back if no ID is provided
        header("Location: view.php?message=No User ID Provided");
        exit();
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
    <title>Delete Confirmation</title>
</head>

<body>

<div class="container mt-5">
    
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <a href="delete.php?id=<?= htmlspecialchars($id); ?>&confirm=yes" class="btn btn-danger">Yes, Delete</a>
                    <a href="view.php" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
// Automatically show the modal when the page loads
document.addEventListener('DOMContentLoaded', function() {
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
        backdrop: 'static'
    });
    deleteModal.show();
});
</script>
</body>
</html>
