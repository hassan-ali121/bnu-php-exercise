<?php
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

$message = ""; // Initialize the message variable

// Check if the user is logged in
if (isset($_SESSION['id'])) {
   // If a module has been selected
   if (isset($_POST['selmodule'])) {
      $moduleCode = $_POST['selmodule'];
      $sql = "INSERT INTO studentmodules VALUES ('{$_SESSION['id']}', '$moduleCode')";
      $result = mysqli_query($conn, $sql);
      if ($result) {
         $message = "<p class='alert alert-success'>The module $moduleCode has been assigned to you</p>";
      } else {
         $message = "<p class='alert alert-danger'>Failed to assign the module. Please try again.</p>";
      }
   } else {
      // If a module has not been selected, display the module selection form
      $sql = "SELECT * FROM module";
      $result = mysqli_query($conn, $sql);

      $message .= "<h1 class='text-center mb-4'>Assign Modules</h1>";
      $message .= "<form name='frmassignmodule' action='' method='post' class='text-left'>";
      $message .= "<div class='form-group'>";
      $message .= "<label for='selmodule'>Select a module to assign</label><br/>";
      $message .= "<select name='selmodule' class='form-control'>";
      
      // Display the module names in a dropdown selection box
      while($row = mysqli_fetch_array($result)) {
         $message .= "<option value='{$row['modulecode']}'>{$row['name']}</option>";
      }
      
      $message .= "</select></div>";
      $message .= "<button type='submit' name='confirm' class='btn btn-primary'>Save</button>";
      $message .= "</form>";
   }

   // Include header and navigation templates
   echo template("templates/partials/header.php");
   echo template("templates/partials/nav.php");

   // Display the message
   echo "<div class='container'>";
   echo $message;
   echo "</div>";

   // Render the template
   echo template("templates/default.php", array('content' => ''));

   // Include footer template
   echo template("templates/partials/footer.php");

} else {
   // Redirect to the login page if the user is not logged in
   header("Location: index.php");
}
?>

