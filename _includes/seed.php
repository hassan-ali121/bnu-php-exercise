<?php

   include("_includes/config.inc");
   include("_includes/dbconnect.inc");
   include("_includes/functions.inc");
    
   //included faker library
   require 'vendor/autoload.php';

  //Checks whether we are logged in
   if (isset($_SESSION['id'])) {
   // Create a Faker generator
   $faker = Faker\Factory::create();

   // Prepare SQL statement to insert student records
   $stmt = $pdo->prepare("INSERT INTO student (studentid,password,firstname, lastname,dob, house, town, county,country,postcode) VALUES (:studentid,:password, :firstname,:lastname,:dob,:house,:town,:county,:country,:postcode)");

   for ($i = 0; $i < 5; $i++) {
    // Generate fake data for each student
    $firstname = $faker->firstname;
    $lastname=$faker->lastname;
    $password=$faker->password;
    $dob = $faker->dob;
    $house = $faker->house;
    $town =  $faker->town;
    $county= $faker->county;
    $country= $faker->country;
    $postcode= $faker->postcode;
    $studentid = $faker->randomFloat(0, 100); // Assuming grades are float values

    // Bind parameters and execute the statement
    $stmt->bindParam(':studentid', $studentid);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':house', $house);
    $stmt->bindParam(':town', $town);
    $stmt->bindParam(':county', $county);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':postcode', $postcode);
    $stmt->execute();
}
echo "Student records inserted successfully.";
   } else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Close database connection


?>
