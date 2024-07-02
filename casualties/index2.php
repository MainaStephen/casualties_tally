<?php
require_once('dbconnect.php');

// Fetch data from the database
$query = "SELECT name, image, location, hospital_name, age, gender, status FROM patients";
$result = mysqli_query($con, $query);

if (!$result) {
    die('Error: ' . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="../assets/images/account.jpeg">
    <meta name="author" content="wpoceans">
    <title>Reject Finance Bill - Details of Injured and Deceased</title>
    <link href="assets/css/themify-icons.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/flaticon.css" rel="stylesheet">
    <link href="assets/css/odometer-theme-default.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/owl.carousel.css" rel="stylesheet">
    <link href="assets/css/owl.theme.css" rel="stylesheet">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/slick-theme.css" rel="stylesheet">
    <link href="assets/css/swiper.min.css" rel="stylesheet">
    <link href="assets/css/owl.transitions.css" rel="stylesheet">
    <link href="assets/css/jquery.fancybox.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <style>
        img.accounts-image {
            width: 53%;
            position: relative;
            left: 40rem;
        }
        img.accounts-image.\32 {
            width: 59%;
            position: relative;
            left: 38rem;
        }
    </style>
    
        <!--  -->

      <div class="header-images">

      <img class="header-image" src="./assets/images/account.jpeg" alt="">
      <img class="header-image" src="./assets/images/account2.jpeg" alt="">
      </div>

        <div class="case-area section-padding">
            <div class="container">
                <div class="col-md-6 col-md-offset-3">
                    <div class="section-title section-title2 text-center">
                        <div class="thumb-text">
                            <span>Casualties</span>
                        </div>
                        <h2>Details</h2>
                        <p>Details of the Injured and Deceased</p>
                    </div>
                </div>
               

                <div class="row">
                <?php
while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='col-lg-4 col-md-6 col-sm-6 col-12'>";
    echo "<div class='cause-item'>";
    echo "<div class='cause-top'>";
    echo "<div class='cause-img'>";
    
    // Display the image (assuming it's stored as BLOB)
    echo "<td><img class='casualty-img' src='data:image/jpeg;base64," . $row['image'] . "' alt='Image' style='width:100px; height:auto;'/></td>";
    
    echo "</div>";
    echo "</div>";
    echo "<div class='cause-text'>";
    echo "<div class='ul-wrapper'>";
    echo "<ul>";
    echo "<li class='status-li'>Status: " . htmlspecialchars($row['status']) . "</li>";
    echo "<li class='name-li'>Name: " . htmlspecialchars($row['name']) . "</licla>";
    echo "<li class='age-li'>Age: " . htmlspecialchars($row['age']) . "</li>";
    echo "<li class='genger-li'>Gender: " . htmlspecialchars($row['gender']) . "</li>";
    echo "<li class='location-li'>Location: " . htmlspecialchars($row['location']) . "</li>";
    echo "<li class='hospital-li'>Hospital Name: " . htmlspecialchars($row['hospital_name']) . "</li>";    
    
    echo "</ul>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}
?>

                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/swiper.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
