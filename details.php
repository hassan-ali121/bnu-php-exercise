<?php
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    // Check if the form has been submitted
    if (isset($_POST['submit'])) {
        // Build an SQL statement to update the student details
        $sql = "UPDATE student SET firstname = '" . $_POST['txtfirstname'] . "',";
        $sql .= "lastname = '" . $_POST['txtlastname']  . "',";
        $sql .= "house = '" . $_POST['txthouse']  . "',";
        $sql .= "town = '" . $_POST['txttown']  . "',";
        $sql .= "county = '" . $_POST['txtcounty']  . "',";
        $sql .= "country = '" . $_POST['txtcountry']  . "',";
        $sql .= "postcode = '" . $_POST['txtpostcode']  . "' ";
        $sql .= "WHERE studentid = '" . $_SESSION['id'] . "';";
        $result = mysqli_query($conn, $sql);

        $data['content'] = "<div class='alert alert-success' role='alert'>Your details have been updated</div>";
    } else {
        // Build an SQL statement to return the student record with the id that matches that of the session variable
        $sql = "SELECT * FROM student WHERE studentid='" . $_SESSION['id'] . "';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        // Using HEREDOC notation to allow building of a multi-line string
        $data['content'] = <<<EOD
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">My Details</h2>
                                <form name="frmdetails" action="" method="post">
                                    <div class="form-group">
                                        <label for="txtfirstname">First Name</label>
                                        <input id="txtfirstname" name="txtfirstname" type="text" class="form-control" value="{$row['firstname']}">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtlastname">Surname</label>
                                        <input id="txtlastname" name="txtlastname" type="text" class="form-control" value="{$row['lastname']}">
                                    </div>
                                    <div class="form-group">
                                        <label for="txthouse">Number and Street</label>
                                        <input id="txthouse" name="txthouse" type="text" class="form-control" value="{$row['house']}">
                                    </div>
                                    <div class="form-group">
                                        <label for="txttown">Town</label>
                                        <input id="txttown" name="txttown" type="text" class="form-control" value="{$row['town']}">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtcounty">County</label>
                                        <input id="txtcounty" name="txtcounty" type="text" class="form-control" value="{$row['county']}">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtcountry">Country</label>
                                        <input id="txtcountry" name="txtcountry" type="text" class="form-control" value="{$row['country']}">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtpostcode">Postcode</label>
                                        <input id="txtpostcode" name="txtpostcode" type="text" class="form-control" value="{$row['postcode']}">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
EOD;
    }

    // Render the template
    echo template("templates/default.php", $data);
} else {
    // Redirect to the login page if not logged in
    header("Location: index.php");
}

// Include footer
echo template("templates/partials/footer.php");
?>
