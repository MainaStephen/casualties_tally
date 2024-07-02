<?php

require_once('dbconnect.php');

if (isset($_POST['delete-button'])) {
    $id = $_POST['id'];

    // Perform SQL DELETE operation
    $sql = "DELETE FROM patients WHERE id = '$id'";

    if ($con->query($sql) === TRUE) {
        echo "Record deleted successfully";
        // Redirect back to the dashboard or wherever appropriate
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Error deleting record: " . $con->error;
    }
}

// Close database connection
$con->close();
?>