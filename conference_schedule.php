<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - Schedule</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';
?>

<h1>Conference Schedule for a Day</h1>

<!-- Schedule selection form -->
<form action="conference_schedule.php" method="post">
   <label for="seminarDate">Select Date:</label>
   <select name="seminarDate" id="seminarDate">
   <?php
      // get distinct seminar dates for dropdown
      $query = "SELECT DISTINCT seminarDate FROM seminar ORDER BY seminarDate";
      $result = $connection->query($query);
      while ($row = $result->fetch()) {
         echo "<option value='" . $row['seminarDate'] . "'>" . $row['seminarDate'] . "</option>";
      }
   ?>
   </select>
   <input type="submit" value="Show Schedule">
</form>

<?php
// Process form submission for schedule display
   if (isset($_POST['seminarDate'])) {
      $seminarDate = $_POST['seminarDate'];
      // retrieve seminars for selected date ordered by startTime
      $query = "SELECT * FROM seminar WHERE seminarDate = :seminarDate ORDER BY startTime";
      $stmt = $connection->prepare($query);
      $stmt->execute(array(':seminarDate' => $seminarDate));
      $seminars = $stmt->fetchAll();
      
      if ($seminars) {
         // Display schedule table for the chosen date
         echo "<h2>Schedule for " . $seminarDate . ":</h2>";
         echo "<table border='1'>";
         echo "<tr><th>Seminar Name</th><th>Room</th><th>Start Time</th><th>End Time</th></tr>";
         foreach ($seminars as $seminar) {
            echo "<tr>";
            echo "<td>" . $seminar['seminarName'] . "</td>";
            echo "<td>" . $seminar['roomLocation'] . "</td>";
            echo "<td>" . $seminar['startTime'] . "</td>";
            echo "<td>" . $seminar['endTime'] . "</td>";
            echo "</tr>";
         }
         echo "</table>";
      } else {
         // Display message when no seminars are found
         echo "<p>No seminars found for " . $seminarDate . ".</p>";
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
