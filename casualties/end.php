<?php

require_once('dbconnect.php');

if (isset($_POST['details-submit'])) {
    // Check if file upload is empty
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        // Check for upload errors
        if ($fileError !== UPLOAD_ERR_OK) {
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
            ];

            $errorCode = $fileError;
            $errorMessage = isset($uploadErrors[$errorCode]) ? $uploadErrors[$errorCode] : 'Unknown error';

            $message = "File upload error: " . $errorMessage;
            header("Location: dashboard.html?message1=" . urlencode($message));
            exit();
        }

        // Validate file type (assuming image file)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedTypes)) {
            $message = "Invalid image format. Please upload JPEG, PNG, or GIF files.";
            header("Location: dashboard.html?message1=" . urlencode($message));
            exit();
        }

        // Function to compress the image
        function compressImage($source, $destination, $quality) {
            $info = getimagesize($source);

            if ($info['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($source);
            } elseif ($info['mime'] == 'image/gif') {
                $image = imagecreatefromgif($source);
            } elseif ($info['mime'] == 'image/png') {
                $image = imagecreatefrompng($source);
                // Convert PNG to true color for proper compression
                $image = imagepalettetotruecolor($image) ? $image : imagecreatetruecolor(imagesx($image), imagesy($image));
                imagealphablending($image, true);
                imagesavealpha($image, true);
            } else {
                return false;
            }

            // Compress image
            imagejpeg($image, $destination, $quality);
            return $destination;
        }

        // Compress the uploaded image
        $compressedImage = 'uploads/compressed_' . $fileName;
        if (!compressImage($fileTmpName, $compressedImage, 75)) {
            $message = "Failed to compress image.";
            header("Location: dashboard.html?message1=" . urlencode($message));
            exit();
        }

        // Read the compressed image
        $imageData = base64_encode(file_get_contents($compressedImage));

        // Handle database insertion here
        $name = $_POST['name'];
        $location = $_POST['location'];
        $hospital = $_POST['hospital'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $status = $_POST['status'];

        // Inserting into the database
        $query = "INSERT INTO patients (name, image, location, hospital_name, age, gender, status) 
                  VALUES ('$name', '$imageData', '$location', '$hospital', '$age', '$gender', '$status')";

        if (mysqli_query($con, $query)) {
            $message = "Data submitted successfully!";
            header("Location: dashboard.php?message=" . urlencode($message));
            exit();
        } else {
            $message = "Error: " . mysqli_error($con);
            header("Location: dashboard.php?message1=" . urlencode($message));
            exit();
        }
    } else {
        $message = "Please upload an image.";
        header("Location: dashboard.php?message1=" . urlencode($message));
        exit();
    }
} else {
    $message = "Please fill all the required fields.";
    header("Location: dashboard.php?message1=" . urlencode($message));
    exit();
}
?>
