<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - Attendees List</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';

// Students: join with attendeeEmail to get emails (group_concat in case of multiple emails)
   $query_students = "SELECT a.attendeeID, a.attendeeName, a.fee, 
                             GROUP_CONCAT(ae.email SEPARATOR '<br>') AS emails 
                      FROM attendee a 
                      LEFT JOIN attendeeEmail ae ON a.attendeeID = ae.attendeeID 
                      WHERE a.type = 'student'
                      GROUP BY a.attendeeID, a.attendeeName, a.fee";
   $result_students = $connection->query($query_students);

// Professionals: join with attendeeEmail to get emails
   $query_professionals = "SELECT a.attendeeID, a.attendeeName, a.fee, 
                                  GROUP_CONCAT(ae.email SEPARATOR '<br>') AS emails 
                           FROM attendee a 
                           LEFT JOIN attendeeEmail ae ON a.attendeeID = ae.attendeeID 
                           WHERE a.type = 'professional'
                           GROUP BY a.attendeeID, a.attendeeName, a.fee";
   $result_professionals = $connection->query($query_professionals);

// Sponsors: join with sponsor table to get company names and emails
   $query_sponsors = "SELECT a.attendeeID, a.attendeeName, 
                             GROUP_CONCAT(ae.email SEPARATOR '<br>') AS emails, 
                             s.sponsorName 
                      FROM attendee a 
                      JOIN sponsor s ON a.attendeeID = s.attendeeID 
                      LEFT JOIN attendeeEmail ae ON a.attendeeID = ae.attendeeID 
                      WHERE a.type = 'sponsor'
                      GROUP BY a.attendeeID, a.attendeeName, s.sponsorName";
   $result_sponsors = $connection->query($query_sponsors);
?>

<h1>Attendees List</h1>

<!-- Students table -->
<h2>Students</h2>
<table border="1">
   <tr>
      <th>Attendee ID</th>
      <th>Name</th>
      <th>Fee</th>
      <th>Email(s)</th>
   </tr>
   <?php while ($row = $result_students->fetch()) { ?>
      <tr>
         <td><?php echo $row['attendeeID']; ?></td>
         <td><?php echo $row['attendeeName']; ?></td>
         <td><?php echo $row['fee']; ?></td>
         <td><?php echo $row['emails']; ?></td>
      </tr>
   <?php } ?>
</table>

<!-- Professionals table -->
<h2>Professionals</h2>
<table border="1">
   <tr>
      <th>Attendee ID</th>
      <th>Name</th>
      <th>Fee</th>
      <th>Email(s)</th>
   </tr>
   <?php while ($row = $result_professionals->fetch()) { ?>
      <tr>
         <td><?php echo $row['attendeeID']; ?></td>
         <td><?php echo $row['attendeeName']; ?></td>
         <td><?php echo $row['fee']; ?></td>
         <td><?php echo $row['emails']; ?></td>
      </tr>
   <?php } ?>
</table>

<!-- Sponsors table -->
<h2>Sponsors</h2>
<table border="1">
   <tr>
      <th>Attendee ID</th>
      <th>Name</th>
      <th>Company</th>
      <th>Email(s)</th>
   </tr>
   <?php while ($row = $result_sponsors->fetch()) { ?>
      <tr>
         <td><?php echo $row['attendeeID']; ?></td>
         <td><?php echo $row['attendeeName']; ?></td>
         <td><?php echo $row['sponsorName']; ?></td>
         <td><?php echo $row['emails']; ?></td>
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
