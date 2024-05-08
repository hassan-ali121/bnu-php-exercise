<?php
if(isset($_POST['delete_students']) && !empty($_POST['selected_students'])) {
    // Include necessary files for database connection
    include("_includes/config.inc");
    include("_includes/dbconnect.inc");

    // Escape and sanitize selected student IDs
    $selected_students = array_map('intval', $_POST['selected_students']);
    $selected_students = implode(',', $selected_students);

    // Construct SQL DELETE statement
    $sql = "DELETE FROM student WHERE studentid IN ($selected_students)";

    // Execute the SQL statement
    if (mysqli_query($conn, $sql)) {
        echo "Selected student records deleted successfully.";
    } else {
        echo "Error deleting student records: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>

