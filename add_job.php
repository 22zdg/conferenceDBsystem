<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - Add Job Listing</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';
?>

<h1>Add a New Job Listing</h1>

<!-- Job listing form -->
<form action="add_job.php" method="post">
   Sponsor Name:
   <select name="sponsorName" required>
      <?php
         // list sponsoring companies for dropdown
         $query = "SELECT sponsorName FROM sponsoringCompany";
         $result = $connection->query($query);
         while ($row = $result->fetch()) {
            echo "<option value=\"" . $row['sponsorName'] . "\">" . $row['sponsorName'] . "</option>";
         }
      ?>
   </select><br>
   Job Title: <input type="text" name="jobTitle" required><br>
   Pay Rate: <input type="text" name="payRate" required><br>
   City: <input type="text" name="city" required><br>
   Street: <input type="text" name="street" required><br>
   Postal Code: <input type="text" name="postalCode" required><br>
   <input type="submit" value="Add Job Listing">
</form>

<?php
// Process form submission
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // retrieve form data
      $sponsorName = $_POST['sponsorName'];
      $jobTitle    = $_POST['jobTitle'];
      $payRate     = $_POST['payRate'];
      $city        = $_POST['city'];
      $street      = $_POST['street'];
      $postalCode  = $_POST['postalCode'];
      
      // assign a new jobAdID by finding the current maximum for the sponsor and adding one
      $query = "SELECT MAX(jobAdID) AS maxID FROM jobAd WHERE sponsorName = :sponsorName";
      $stmt = $connection->prepare($query);
      $stmt->execute(array(':sponsorName' => $sponsorName));
      $row = $stmt->fetch();
      $newJobAdID = intval($row['maxID']) + 1;
      
      // insert job listing into database
      $query = "INSERT INTO jobAd (sponsorName, jobAdID, jobTitle, payRate, city, street, postalCode)
                VALUES (:sponsorName, :jobAdID, :jobTitle, :payRate, :city, :street, :postalCode)";
      $stmt = $connection->prepare($query);
      $stmt->execute(array(
         ':sponsorName' => $sponsorName,
         ':jobAdID'     => $newJobAdID,
         ':jobTitle'    => $jobTitle,
         ':payRate'     => $payRate,
         ':city'        => $city,
         ':street'      => $street,
         ':postalCode'  => $postalCode
      ));
      
      // display success message
      echo "<p>New job listing added successfully!</p>";
   }
   $connection = NULL;
?>

<!-- Link back to home page -->
<p>
   <a href="conference.php">Return to Home</a>
</p>
</body>
</html>
