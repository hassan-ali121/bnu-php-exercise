<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Student</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .alert {
            margin-top: 20px;
        }
        .btn-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Include necessary files for database connection
        include("_includes/config.inc");
        include("_includes/dbconnect.inc");

        // Function to sanitize input and prevent SQL injection
        function sanitize($data) {
            global $conn;
            return mysqli_real_escape_string($conn, $data);
        }

        // Retrieve form data
        $studentid = sanitize($_POST['studentid']);
        $password = sanitize($_POST['password']);
        $confirm_password = sanitize($_POST['confirm_password']);
        $firstname = sanitize($_POST['firstname']);
        $lastname = sanitize($_POST['lastname']);
        $dob = sanitize($_POST['dob']);
        $house = sanitize($_POST['house']);
        $town = sanitize($_POST['town']);
        $county = sanitize($_POST['county']);
        $country = sanitize($_POST['country']);
        $postcode = sanitize($_POST['postcode']);

        // File upload handling
        $imageFilePath = "";
        $targetDirectory = "uploads/"; // Directory where uploaded images will be stored
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check file size
        if ($_FILES["image"]["size"] > 5000000) {
            echo '<div class="alert alert-danger" role="alert">Sorry, your file is too large.</div>';
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo '<div class="alert alert-danger" role="alert">Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>';
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo '<div class="alert alert-danger" role="alert">Sorry, your file was not uploaded.</div>';
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                echo '<div class="alert alert-success" role="alert">The file '. htmlspecialchars(basename($_FILES["image"]["name"])). ' has been uploaded.</div>';
                // Now you can insert the image file path into the database along with other student details
                $imageFilePath = $targetFile;
            } else {
                echo '<div class="alert alert-danger" role="alert">Sorry, there was an error uploading your file.</div>';
            }
        }

        // Validate form data
        if ($password !== $confirm_password) {
            echo '<div class="alert alert-danger" role="alert">Passwords do not match.</div>';
            exit;
        }

        // Encrypt password securely (you may use a stronger encryption method)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Build SQL statement to insert student record
        $sql = "INSERT INTO student (studentid, password, firstname, lastname, dob, house, town, county, country, postcode, image) ";
        $sql .= "VALUES ('$studentid', '$hashedPassword', '$firstname', '$lastname', '$dob', '$house', '$town', '$county', '$country', '$postcode', '$imageFilePath')";

        // Execute SQL query
        $result = mysqli_query($conn, $sql);

        // Check if insertion was successful
        if ($result) {
            echo '<div class="alert alert-success" role="alert">Student record added successfully.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error adding student record: ' . mysqli_error($conn) . '</div>';
        }

        // Close database connection
        mysqli_close($conn);
        ?>
        <div class="btn-container text-center">
            <a href="students.php" class="btn btn-primary">View Students</a>
            <a href="addstudent.php" class="btn btn-secondary">Add Another Student</a>
        </div>
    </div>
</body>
</html>
