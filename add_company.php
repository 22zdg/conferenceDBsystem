<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - Add Sponsoring Company</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';
?>

<h1>Add a New Sponsoring Company</h1>

<!-- Company form -->
<form action="add_company.php" method="post">
   Company Name: <input type="text" name="sponsorName" required><br>
   Tier:
   <select name="tier" required>
    <option value="">None</option>
    <option value="Bronze">Bronze</option>
    <option value="Silver">Silver</option>
    <option value="Gold">Gold</option>
    <option value="Platinum">Platinum</option>
    </select><br>
   Emails Sent: <input type="text" name="emailsSent"><br>
   <input type="submit" value="Add Company">
</form>

<?php
// Process form submission
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // retrieve form data
      $sponsorName  = $_POST['sponsorName'];
      $tier         = $_POST['tier'];
      $emailsSent   = isset($_POST['emailsSent']) ? $_POST['emailsSent'] : 0;

      // Assign amountPaid and emailsAllowed values based on tier
      if ($tier == 'Bronze') {
          $amountPaid = 1000;
          $emailsAllowed = 0;
      } elseif ($tier == 'Silver') {
          $amountPaid = 3000;
          $emailsAllowed = 3;
      } elseif ($tier == 'Gold') {
          $amountPaid = 5000;
          $emailsAllowed = 4;
      } elseif ($tier == 'Platinum') {
          $amountPaid = 10000;
          $emailsAllowed = 5;
      }
      
      // Insert sponsoring company record into database
      $query = "INSERT INTO sponsoringCompany (sponsorName, amountPaid, tier, emailsSent, emailsAllowed)
                VALUES (:sponsorName, :amountPaid, :tier, :emailsSent, :emailsAllowed)";
      $stmt = $connection->prepare($query);
      $stmt->execute(array(
         ':sponsorName'  => $sponsorName,
         ':amountPaid'   => $amountPaid,
         ':tier'         => $tier,
         ':emailsSent'   => $emailsSent,
         ':emailsAllowed'=> $emailsAllowed
      ));

      // Display success message
      echo "<p>New sponsoring company added successfully!</p>";
   }
   $connection = NULL;
?>

<!-- Link back to home page -->
<p>
   <a href="conference.php">Return to Home</a>
</p>
</body>
</html>
