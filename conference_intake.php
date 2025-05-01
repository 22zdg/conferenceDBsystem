<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - Conference Intake</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';
?>

<h1>Conference Total Intake</h1>

<?php
   // Calculate total registration from all attendees
   $query = "SELECT SUM(fee) AS totalRegistration FROM attendee";
   $result = $connection->query($query);
   $row = $result->fetch();
   $totalRegistration = $row['totalRegistration'];
   
   // Get breakdown registration by attendee type
   $query = "SELECT type, COUNT(*) AS count, SUM(fee) AS totalFee 
             FROM attendee GROUP BY type";
   $result = $connection->query($query);
   
   echo "<h2>Registration Breakdown by Type</h2>";
   echo "<table border='1'>";
   echo "<tr><th>Type</th><th>Number of Attendees</th><th>Total Fee</th></tr>";
   while ($row = $result->fetch()) {
      // output a row for each attendee type
      echo "<tr>";
      echo "<td>" . $row['type'] . "</td>";
      echo "<td>" . $row['count'] . "</td>";
      echo "<td>$" . $row['totalFee'] . "</td>";
      echo "</tr>";
   }
   echo "</table>";
   
   // Calculate total sponsorship from sponsoring companies
   $query = "SELECT SUM(amountPaid) AS totalSponsorship FROM sponsoringCompany";
   $result = $connection->query($query);
   $row = $result->fetch();
   $totalSponsorship = $row['totalSponsorship'];

   // Get breakdown sponsors by tier
   $query = "SELECT tier, COUNT(*) AS count, SUM(amountPaid) AS totalAmount 
             FROM sponsoringCompany GROUP BY tier";
   $result = $connection->query($query);
   
   echo "<h2>Sponsors Breakdown by Tier</h2>";
   echo "<table border='1'>";
   echo "<tr><th>Tier</th><th>Number of Sponsors</th><th>Total Amount Paid</th></tr>";
   while ($row = $result->fetch()) {
      // output a row for each sponsor tier
      echo "<tr>";
      echo "<td>" . $row['tier'] . "</td>";
      echo "<td>" . $row['count'] . "</td>";
      echo "<td>$" . $row['totalAmount'] . "</td>";
      echo "</tr>";
   }
   echo "</table>";
   
   // Display overall totals
   echo "<h2>Overall Totals</h2>";
   echo "<p>Total Registration Amount: $" . $totalRegistration . "</p>";
   echo "<p>Total Sponsorship Amount: $" . $totalSponsorship . "</p>";
?>

<?php
   $connection = NULL;
?>

<!-- Link back to home page -->
<p>
   <a href="conference.php">Return to Home</a>
</p>
</body>
</html>
