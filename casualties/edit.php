<?php
require_once('dbconnect.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $hospital = $_POST['hospital'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $status = $_POST['status'];

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $sql = "UPDATE patients SET name='$name', location='$location', hospital_name='$hospital', age='$age', gender='$gender', status='$status', image='$image' WHERE id='$id'";
    } else {
        $sql = "UPDATE patients SET name='$name', location='$location', hospital_name='$hospital', age='$age', gender='$gender', status='$status' WHERE id='$id'";
    }

    if ($con->query($sql) === TRUE) {
        echo "Record updated successfully";
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Error updating record: " . $con->error;
    }
}

$con->close();
?>
