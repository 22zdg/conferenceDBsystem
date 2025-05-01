<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - Company Jobs</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';
   
// Get list of companies
   $query = "SELECT sponsorName FROM sponsoringCompany";
   $result = $connection->query($query);
   $companies = $result->fetchAll();
?>

<!-- Company selection form -->
<h1>Jobs Available for a Company</h1>
<form action="company_jobs.php" method="post">
   <label for="sponsorName">Choose a Company:</label>
   <select name="sponsorName" id="sponsorName">
      <?php foreach ($companies as $company) { ?>
         <option value="<?php echo $company['sponsorName']; ?>">
            <?php echo $company['sponsorName']; ?>
         </option>
      <?php } ?>
   </select>
   <input type="submit" value="Show Jobs">
</form>

<?php
// Process form submission for company jobs
   if (isset($_POST['sponsorName'])) {
      $sponsorName = $_POST['sponsorName'];
      // retrieve jobs for selected company
      $query = "SELECT jobAdID, jobTitle, payRate, city, street, postalCode 
                FROM jobAd WHERE sponsorName = :sponsorName";
      $stmt = $connection->prepare($query);
      $stmt->execute(array(':sponsorName' => $sponsorName));
      $jobs = $stmt->fetchAll();
      
      if ($jobs) {
         // display jobs table
         echo "<h2>Jobs for " . $sponsorName . ":</h2>";
         echo "<table border='1'>";
         echo "<tr><th>Job ID</th><th>Title</th><th>Pay Rate</th><th>City</th><th>Street</th><th>Postal Code</th></tr>";
         foreach ($jobs as $job) {
            // output each job row
            echo "<tr>";
            echo "<td>" . $job['jobAdID'] . "</td>";
            echo "<td>" . $job['jobTitle'] . "</td>";
            echo "<td>" . $job['payRate'] . "</td>";
            echo "<td>" . $job['city'] . "</td>";
            echo "<td>" . $job['street'] . "</td>";
            echo "<td>" . $job['postalCode'] . "</td>";
            echo "</tr>";
         }
         echo "</table>";
      } else {
         // display no jobs message
         echo "<p>No jobs found for " . $sponsorName . ".</p>";
      }
   }
   $connection = NULL;
?>

<!-- Link back to home page -->
<p>
   <a href="conference.php">Return to Home</a>
</p>
</body>
</html>
