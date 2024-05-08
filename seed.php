<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Student Records</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Insert Student Records</h2>
        <?php
        // Include necessary files for database connection and functions
        include("_includes/config.inc");
        include("_includes/dbconnect.inc");
        include("_includes/functions.inc");

        // Include Faker autoload.php file
        require_once 'vendor/autoload.php';

        // Create a Faker generator
        $faker = Faker\Factory::create();

        // Array to store student records
        $students = [];

        // Generate 5 student records
        for ($i = 0; $i < 5; $i++) {
            $students[] = [
                $faker->randomNumber(6), // Student ID
                $faker->password(),      // Password
                $faker->firstName(),     // First Name
                $faker->lastName(),      // Last Name
                $faker->date('Y-m-d'),   // Date of Birth
                $faker->streetAddress(), // House
                $faker->city(),          // Town
                $faker->state(),         // County
                'USA',                   // Country
                $faker->postcode()       // Postcode
            ];
        }

        // Display generated student records in a table
        echo "<table class='table table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Student ID</th>";
        echo "<th>Password</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Date of Birth</th>";
        echo "<th>House</th>";
        echo "<th>Town</th>";
        echo "<th>County</th>";
        echo "<th>Country</th>";
        echo "<th>Postcode</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($students as $student) {
            echo "<tr>";
            echo "<td>{$student[0]}</td>";
            echo "<td>{$student[1]}</td>";
            echo "<td>{$student[2]}</td>";
            echo "<td>{$student[3]}</td>";
            echo "<td>{$student[4]}</td>";
            echo "<td>{$student[5]}</td>";
            echo "<td>{$student[6]}</td>";
            echo "<td>{$student[7]}</td>";
            echo "<td>{$student[8]}</td>";
            echo "<td>{$student[9]}</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";

        // Show confirmation button
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="confirm_insert" value="1">
            <button type="submit" class="btn btn-primary">Confirm Insertion</button>
        </form>
        <?php

        // Process insertion if confirmation is received
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_insert'])) {
            // Prepare the SQL statement
            $sql = "INSERT INTO student (studentid, password, firstname, lastname, dob, house, town, county, country, postcode) ";
            $sql .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepare the statement
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                // Loop through each student record and insert into the database
                foreach ($students as $student) {
                    // Bind parameters
                    mysqli_stmt_bind_param($stmt, "isssssssss", $student[0], $student[1], $student[2], $student[3], $student[4], $student[5], $student[6], $student[7], $student[8], $student[9]);

                    // Execute the statement
                    $result = mysqli_stmt_execute($stmt);

                    // Check if insertion was successful
                    if ($result) {
                        echo "<div class='alert alert-success'>Record inserted successfully for {$student[2]} {$student[3]}</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error inserting record for {$student[2]} {$student[3]}: " . mysqli_error($conn) . "</div>";
                    }
                }
                
                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                echo "<div class='alert alert-danger'>Error preparing statement: " . mysqli_error($conn) . "</div>";
            }

            // Close database connection
            mysqli_close($conn);
        }
        ?>
    </div>
</body>
</html>
