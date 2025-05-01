<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - All Jobs</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';

   // Retrieve job listings from database
   $query = "SELECT sponsorName, jobAdID, jobTitle, payRate, city, street, postalCode FROM jobAd";
   $result = $connection->query($query);
?>
<!-- Display all available jobs in a table -->
<h1>All Available Jobs</h1>
<table border="1">
   <tr>
      <th>Company</th>
      <th>Job ID</th>
      <th>Job Title</th>
      <th>Pay Rate</th>
      <th>City</th>
      <th>Street</th>
      <th>Postal Code</th>
   </tr>
   <?php while ($row = $result->fetch()) { ?>
      <?php // output a row for each job ?>
      <tr>
         <td><?php echo $row['sponsorName']; ?></td>
         <td><?php echo $row['jobAdID']; ?></td>
         <td><?php echo $row['jobTitle']; ?></td>
         <td><?php echo $row['payRate']; ?></td>
         <td><?php echo $row['city']; ?></td>
         <td><?php echo $row['street']; ?></td>
         <td><?php echo $row['postalCode']; ?></td>
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
