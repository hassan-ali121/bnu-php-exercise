<?php
// Include necessary files for database connection
include("_includes/config.inc");
include("_includes/dbconnect.inc");

// Check if delete form is submitted
if(isset($_POST['delete'])) {
    // Array to store selected student IDs
    $selectedIds = $_POST['selectedIds'];
    
    if (!empty($selectedIds)) {
        // Convert array values to comma-separated string
        $idList = implode(",", $selectedIds);
        
        // SQL query to delete selected student records
        $sqlDelete = "DELETE FROM student WHERE studentid IN ($idList)";
        
        // Execute delete query
        $resultDelete = mysqli_query($conn, $sqlDelete);
        
        // Check if deletion was successful
        if ($resultDelete) {
            echo "<p>Selected student records have been deleted successfully.</p>";
        } else {
            echo "<p>Error deleting selected student records: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>No student records selected for deletion.</p>";
    }
}

// Fetch all student records from the database
$sql = "SELECT * FROM student";
$result = mysqli_query($conn, $sql);

// Check if any records were returned
if (mysqli_num_rows($result) > 0) {
    // Start form for deleting records
    echo "<form id='deleteForm' method='post' onsubmit='return confirmDelete()'>";
    echo "<table border='1'>";
    echo "<tr><th>Select</th><th>Student ID</th><th>Password</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th><th>House</th><th>Town</th><th>County</th><th>Country</th><th>Postcode</th></tr>";

    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><input type='checkbox' name='selectedIds[]' value='".$row["studentid"]."'></td>";
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
        echo "</tr>";
    }
    echo "</table>";
    // Add Delete button with confirmation dialog
    echo "<input type='submit' name='delete' value='Delete Selected'>";
    echo "</form>";
} else {
    echo "0 results";
}

// Close database connection
mysqli_close($conn);
?>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete the selected student records?");
    }
</script>
