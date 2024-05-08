<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .content-container {
        
            margin: 0 auto; /* Center-align content */
            padding: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        img.student-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        .btn{
            margin-top:20px;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <?php
        // Include necessary files for database connection
        include("_includes/config.inc");
        include("_includes/dbconnect.inc");

        // Function to sanitize input and prevent SQL injection
        function sanitize($data) {
            global $conn;
            return mysqli_real_escape_string($conn, $data);
        }

        // Check if delete request is made
        if (isset($_POST['delete'])) {
            // Ensure user confirms deletion
            if (!empty($_POST['delete_ids'])) {
                $delete_ids = array_map('sanitize', $_POST['delete_ids']);
                $ids_str = implode(',', $delete_ids);

                // Display confirmation dialog
                echo "<script>
                        var confirmDelete = confirm('Are you sure you want to delete the selected student(s)?');
                        if (confirmDelete) {
                            window.location.href = 'students.php?delete=true&ids=" . $ids_str . "';
                        } else {
                            alert('Deletion canceled');
                        }
                      </script>";
            } else {
                echo "<script>alert('Please select at least one student to delete');</script>";
                // Redirect back to students.php if no student is selected for deletion
                echo "<script>window.location.href = 'students.php';</script>";
            }
        }

        // Check if confirmed deletion
        if (isset($_GET['delete']) && isset($_GET['ids'])) {
            $ids = sanitize($_GET['ids']);
            $sql = "DELETE FROM student WHERE studentid IN ($ids)";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Records deleted successfully');</script>";
                // Redirect back to students.php after deletion
                echo "<script>window.location.href = 'students.php';</script>";
            } else {
                echo "<script>alert('Error deleting records');</script>";
                // Redirect back to students.php after deletion failure
                echo "<script>window.location.href = 'students.php';</script>";
            }
        }

        // Fetch all student records from the database
        $sql = "SELECT * FROM student";
        $result = mysqli_query($conn, $sql);

        // Check if any records were returned
        if (mysqli_num_rows($result) > 0) {
            // Start HTML form
            echo "<form method='post'>";
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-dark'><tr><th><input type='checkbox' id='selectAll'></th><th>Student ID</th><th>Password</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th><th>House</th><th>Town</th><th>County</th><th>Country</th><th>Postcode</th><th>Image</th></tr></thead>";
            echo "<tbody>";

            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><input type='checkbox' name='delete_ids[]' value='" . $row["studentid"] . "'></td>";
                echo "<td>" . $row["studentid"] . "</td>";
                echo "<td>" . $row["password"] . "</td>";
                echo "<td>" . $row["firstname"] . "</td>";
                echo "<td>" . $row["lastname"] . "</td>";
                echo "<td>" . $row["dob"] . "</td>";
                echo "<td>" . $row["house"] . "</td>";
                echo "<td>" . $row["town"] . "</td>";
                echo "<td>" . $row["county"] . "</td>";
                echo "<td>" . $row["country"] . "</td>";
                echo "<td>" . $row["postcode"] . "</td>";
                echo "<td><img src='" . $row["image"] . "' alt='Student Image' class='student-image'></td>";
                echo "</tr>";
            }
            // Close table body and add delete button
            echo "</tbody>";
            echo "</table>";
            echo "<input type='submit' name='delete' value='Delete Selected' class='btn btn-danger'>";
            echo "</form>";
        } else {
            echo "<p>No records found.</p>";
        }

        // Close database connection
        mysqli_close($conn);
        ?>
        <button onclick="window.location.href='addstudent.php'" class="btn btn-primary">Add Student</button>
    </div>
    <script>
        // JavaScript code to select/deselect all checkboxes
        document.getElementById("selectAll").addEventListener("change", function() {
            var checkboxes = document.querySelectorAll('input[name="delete_ids[]"]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });
    </script>
</body>
</html>
