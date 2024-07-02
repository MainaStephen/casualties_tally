<?php
require_once('dbconnect.php');

// Fetch data from the database
$query = "SELECT id, name, image, location, hospital_name, image, age, gender, status FROM patients";
$result = mysqli_query($con, $query);


if (!$result) {
    die('Error: ' . mysqli_error($con));
}


// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    // Redirect to login page
    header('Location: login.html');
    exit();
}

// User is logged in, continue displaying the dashboard
$user = $_SESSION['user'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/account.jpeg">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
<div class="container">
    <div class="container my-4">
        <!-- <div class="row">
            <div class="col-md-4">
                <div class="card card1" style="width: 18rem">
                    <div class="card-body">
                        <h5 class="card-title">Total Number of Incidences</h5>
                        <p class="card-text">count</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card2" style="width: 18rem">
                    <div class="card-body">
                        <h5 class="card-title">Number of People Injured</h5>
                        <p class="card-text">count</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card3" style="width: 18rem">
                    <div class="card-body">
                        <h5 class="card-title">Number of People Deceased</h5>
                        <p class="card-text">count</p>
                    </div>
                </div>
            </div>
        </div> -->
    </div>

    <div class="container">
        <button type="button" class="btn btn-primary addbutton" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add casualty
        </button>
        

        <form action="logout.php" method="post">
        <button class='logout-btn' type="submit" style="background: linear-gradient(to right, black 0%, red 50%, green 100%);color: white;border: none;padding: 10px 20px;cursor: pointer;font-weight:bold;border-radius:10px;position: relative;left: 11rem;top: 2rem;">Log Out</button>
    </form>

        <div class="details-table">
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Hospital Name</th>
                    <th>Hospital Location</th>
                    <th>Image</th>
                    <th>Patient Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
    echo "<td>" . htmlspecialchars($row['age']) . "</td>";
    echo "<td>" . htmlspecialchars($row['hospital_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['location']) . "</td>";
    echo "<td><img src='data:image/jpeg;base64," . $row['image'] . "' alt='Image' style='width:100px; height:auto;'/></td>";


    
    
     // Edit button form
     echo "<td>";
     echo "<button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editModal' data-id='" . $row['id'] . "' data-name='" . htmlspecialchars($row['name']) . "' data-gender='" . htmlspecialchars($row['gender']) . "' data-age='" . htmlspecialchars($row['age']) . "' data-hospital_name='" . htmlspecialchars($row['hospital_name']) . "' data-location='" . htmlspecialchars($row['location']) . "' data-status='" . htmlspecialchars($row['status']) . "'>Edit</button>";
     echo "</td>";
 
     // Delete button form
     echo "<td>";
     echo "<form action='delete.php' method='post'>";
     echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
     echo "<button type='submit' name='delete-button' class='btn btn-danger btn-sm ms-2'>Delete</button>";
     echo "</form>";
     echo "</td>";
    
    echo "</tr>";
}
?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Casualty Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="casualtyForm" action="end.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter name" required/>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*" required/>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Hospital Location</label>
                            <input type="text" class="form-control" name="location" placeholder="Enter location" required/>
                        </div>
                        <div class="mb-3">
                            <label for="hospital" class="form-label">Hospital  Name</label>
                            <input type="text" class="form-control" name="hospital" placeholder="Enter hospital" required/>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" name="age" placeholder="Enter age" required/>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label required>
                            <select class="form-select" name="gender">
                                <option value="">Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label required>
                            <select class="form-select" name="status">
                                <option value="">Select Status</option>
                                <option value="deceased">Deceased</option>
                                <option value="injured">Injured</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submitedData" class="btn btn-primary submit-details"
                            name="details-submit">Submit
                    </button>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Patient Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="edit.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit-id" value="">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="edit-name" placeholder="Enter name"/>
                    </div>
                    <div class="mb-3">
                        <label for="edit-image" class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" id="edit-image" accept="image/*"/>
                    </div>
                    <div class="mb-3">
                        <label for="edit-location" class="form-label">Hospital Location</label>
                        <input type="text" class="form-control" name="location" id="edit-location" placeholder="Enter location"/>
                    </div>
                    <div class="mb-3">
                        <label for="edit-hospital" class="form-label">Hospital Name</label>
                        <input type="text" class="form-control" name="hospital" id="edit-hospital" placeholder="Enter hospital"/>
                    </div>
                    <div class="mb-3">
                        <label for="edit-age" class="form-label">Age</label>
                        <input type="number" class="form-control" name="age" id="edit-age" placeholder="Enter age"/>
                    </div>
                    <div class="mb-3">
                        <label for="edit-gender" class="form-label">Gender</label>
                        <select class="form-select" name="gender" id="edit-gender">
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit-status">
                            <option value="">Select Status</option>
                            <option value="deceased">Deceased</option>
                            <option value="injured">Injured</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="editSubmitButton" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- <footer>
    <center>
        Powered By <a href="jumuisha.com">Jumuisha</a>
    </center>
</footer> -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function () {
        $('#submitedData').on('click', function () {
            console.log('here I am');
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function () {
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var gender = button.data('gender');
            var age = button.data('age');
            var hospital_name = button.data('hospital_name');
            var location = button.data('location');
            var status = button.data('status');

            var modal = $(this);
            modal.find('#edit-id').val(id);
            modal.find('#edit-name').val(name);
            modal.find('#edit-gender').val(gender);
            modal.find('#edit-age').val(age);
            modal.find('#edit-hospital').val(hospital_name);
            modal.find('#edit-location').val(location);
            modal.find('#edit-status').val(status);
        });

        $('#editSubmitButton').on('click', function () {
            $('#editForm').submit();
        });
    });
</script>

</body>
</html>
<?php
mysqli_close($con);
?>
