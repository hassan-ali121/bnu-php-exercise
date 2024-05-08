<?php
// Include necessary files for database connection
include("_includes/config.inc");
include("_includes/dbconnect.inc");

// Function to sanitize input and prevent SQL injection
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}

// Validate and sanitize form inputs
$studentid = sanitize($_POST['studentid']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password securely
$firstname = sanitize($_POST['firstname']);
$lastname = sanitize($_POST['lastname']);
$dob = sanitize($_POST['dob']);
$house = sanitize($_POST['house']);
$town = sanitize($_POST['town']);
$county = sanitize($_POST['county']);
$country = sanitize($_POST['country']);
$postcode = sanitize($_POST['postcode']);

// Build SQL INSERT statement
$sql = "INSERT INTO student (studentid, password, firstname, lastname, dob, house, town, county, country, postcode) ";
$sql .= "VALUES ('$studentid', '$password', '$firstname', '$lastname', '$dob', '$house', '$town', '$county', '$country', '$postcode')";

// Execute SQL query
if (mysqli_query($conn, $sql)) {
    echo "New student record added successfully.";
} else {
    echo "Error adding student record: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>
