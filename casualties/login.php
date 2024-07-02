<?php
require_once('dbconnect.php');

$response = array();

if (isset($_POST['login-button'])) {
    $phone_no = $_POST['phone_no'];
    $password = $_POST['password'];

    // Validate and sanitize inputs to prevent SQL injection
    $phone_no = mysqli_real_escape_string($con, $phone_no);
    $password = mysqli_real_escape_string($con, $password);

    // Query to fetch user details based on phone number
    $sql = "SELECT * FROM users WHERE phone_no = '$phone_no'";
    $result = $con->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // User found, fetch user details
            $row = $result->fetch_assoc();

            // Verify password directly (since passwords are stored in plain text)
            if ($password === $row['password']) {
                // Password is correct, prepare user details to send in response
                $user = array(
                    'user_id' => $row['user_id'],
                    'username' => $row['username'],
                    'phone_no' => $row['phone_no'],
                    // Do not include password in user data sent back
                );

                // Start session if not already started
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                // Store user details in session variables
                $_SESSION['user'] = $user;

                // Prepare success response
                $response['error'] = false;
                $response['user'] = $user;
                $response['message'] = 'Login successful';

                // Redirect to dashboard.php
                header('Location: dashboard.php');
                exit(); // Ensure that script execution stops after redirection
            } else {
                // Password is incorrect
                $response['error'] = true;
                $response['message'] = 'Invalid password';

                // Redirect back to the login page with error message
                header('Location: login.html?error=Invalid%20password');
                exit(); // Ensure that script execution stops after redirection
            }
        } else {
            // No user found with the given phone number
            $response['error'] = true;
            $response['message'] = 'User not found';

            // Redirect back to the login page with error message
            header('Location: login.html?error=User%20not%20found');
            exit(); // Ensure that script execution stops after redirection
        }
    } else {
        // Database query error
        $response['error'] = true;
        $response['message'] = 'Database query failed: ' . $con->error;

        // Redirect back to the login page with error message
        header('Location: login.html?error=Database%20query%20failed');
        exit(); // Ensure that script execution stops after redirection
    }
} else {
    // Parameters not provided or invalid API call
    $response['error'] = true;
    $response['message'] = 'Invalid API call';

    // Redirect back to the login page with error message
    header('Location: login.html?error=Invalid%20API%20call');
    exit(); // Ensure that script execution stops after redirection
}

// Close database connection
$con->close();

// Send JSON response
echo json_encode($response);
?>
