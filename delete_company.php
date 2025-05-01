<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - Delete Sponsoring Company</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';
   
// Get list of sponsoring companies
   $query = "SELECT sponsorName FROM sponsoringCompany";
   $result = $connection->query($query);
   $companies = $result->fetchAll();
?>

<h1>Delete a Sponsoring Company</h1>

<!-- Delete form -->
<form action="delete_company.php" method="post">
   <label for="sponsorName">Choose a Company to Delete:</label>
   <select name="sponsorName" id="sponsorName">
      <?php foreach ($companies as $company) { ?>
         <option value="<?php echo $company['sponsorName']; ?>">
            <?php echo $company['sponsorName']; ?>
         </option>
      <?php } ?>
   </select>
   <input type="submit" value="Delete Company">
</form>

<?php
// Process deletion request
   if (isset($_POST['sponsorName'])) {
      $sponsorName = $_POST['sponsorName'];
      // deleting from sponsoringCompany cascades to remove related job ads and sponsor attendees
      $query = "DELETE FROM sponsoringCompany WHERE sponsorName = :sponsorName";
      $stmt = $connection->prepare($query);
      $stmt->execute(array(':sponsorName' => $sponsorName));
      echo "<p>Sponsoring company " . $sponsorName . " and its associated records have been deleted.</p>";
   }
   $connection = NULL;
?>

<!-- Link back to home page -->
<p>
   <a href="conference.php">Return to Home</a>
</p>
</body>
</html>
