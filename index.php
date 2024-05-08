<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

echo template("templates/partials/header.php");

if (isset($_GET['return'])) {
    $msg = "";
    if ($_GET['return'] == "fail") {
        $msg = "Login Failed. Please try again.";
    }
    $data['message'] = "<div class='alert alert-danger'>$msg</div>";
}

if (isset($_SESSION['id'])) {
    echo "<div class='container text-center'>";
    echo "<div class='row justify-content-center'>";
    echo "<div class='col-md-6'>";
    echo "<div class='card'>";
    echo "<div class='card-body'>";
    echo "<h1 class='card-title'>Welcome to your dashboard.</h1>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo template("templates/partials/nav.php");
} else {
    echo "<div class='container'>";
    echo "<div class='row justify-content-center'>";
    echo "<div class='col-md-6'>";
    echo "<div class='card'>";
    echo "<div class='card-body'>";
    echo "<h2 class='card-title'>Login</h2>";
    if (isset($data['message'])) {
        echo $data['message'];
    }
    echo "<form name='frmLogin' action='authenticate.php' method='post'>";
    echo "<div class='mb-3'>";
    echo "<label for='txtid' class='form-label'>Student ID:</label>";
    echo "<input type='text' class='form-control' id='txtid' name='txtid' required>";
    echo "</div>";
    echo "<div class='mb-3'>";
    echo "<label for='txtpwd' class='form-label'>Password:</label>";
    echo "<input type='password' class='form-control' id='txtpwd' name='txtpwd' required>";
    echo "</div>";
    echo "<button type='submit' class='btn btn-primary'>Login</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

echo template("templates/partials/footer.php");

?>
