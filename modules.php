
<?php
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    // Build SQL statement to select a student's modules
    $sql = "SELECT * FROM studentmodules sm, module m WHERE m.modulecode = sm.modulecode AND sm.studentid = '" . $_SESSION['id'] . "';";
    $result = mysqli_query($conn, $sql);

    // Prepare page content
    $modules = '';
    if (mysqli_num_rows($result) > 0) {
        $modules .= "<div class='container'>";
        $modules .= "<div class='row justify-content-center'>";
        $modules .= "<div class='col-md-8'>";
        $modules .= "<div class='card'>";
        $modules .= "<div class='card-body'>";
        $modules .= "<h2 class='card-title'>Modules</h2>";
        $modules .= "<div class='table-responsive'>";
        $modules .= "<table class='table table-bordered'>";
        $modules .= "<thead class='thead-light'>";
        $modules .= "<tr>";
        $modules .= "<th>Code</th>";
        $modules .= "<th>Type</th>";
        $modules .= "<th>Level</th>";
        $modules .= "</tr>";
        $modules .= "</thead>";
        $modules .= "<tbody>";
        // Display the modules within the HTML table
        while ($row = mysqli_fetch_assoc($result)) {
            $modules .= "<tr>";
            $modules .= "<td>{$row['modulecode']}</td>";
            $modules .= "<td>{$row['name']}</td>";
            $modules .= "<td>{$row['level']}</td>";
            $modules .= "</tr>";
        }
        $modules .= "</tbody>";
        $modules .= "</table>";
        $modules .= "</div>";
        $modules .= "</div>";
        $modules .= "</div>";
        $modules .= "</div>";
        $modules .= "</div>";
        $modules .= "</div>";
    } else {
        $modules = "<p>No modules found.</p>";
    }

    // Render the template with module content
    $data['content'] = $modules;
    echo template("templates/default.php", $data);
} else {
    // Redirect to the login page if not logged in
    header("Location: index.php");
}

// Include footer
echo template("templates/partials/footer.php");
?>

|