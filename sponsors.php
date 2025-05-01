<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - Sponsors</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';

// Retrieve sponsors and their tiers
   $query = "SELECT sponsorName, tier FROM sponsoringCompany";
   $result = $connection->query($query);
?>

<!-- Sponsors table -->
<h1>Sponsors</h1>
<table border="1">
   <tr>
      <th>Company Name</th>
      <th>Sponsorship Level</th>
   </tr>
   <?php while ($row = $result->fetch()) { ?>
      <tr>
         <td><?php echo $row['sponsorName']; ?></td>
         <td><?php echo $row['tier']; ?></td>
      </tr>
   <?php } ?>
</table>
<?php
   $connection = NULL;
?>

<!-- Link back to home page -->
<p>
   <a href="conference.php">Return to Home</a>
</p>
</body>
</html>