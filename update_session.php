<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - Update Session Details</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';

// Get list of seminars
   $query = "SELECT seminarName FROM seminar";
   $result = $connection->query($query);
   $seminars = $result->fetchAll();
?>

<!-- Session update form -->
<h1>Switch Session's Day/Time/Location</h1>
<form action="update_session.php" method="post">
   <label for="seminarName">Select Seminar:</label>
   <select name="seminarName" id="seminarName">
      <?php foreach ($seminars as $seminar) { ?>
         <option value="<?php echo $seminar['seminarName']; ?>">
            <?php echo $seminar['seminarName']; ?>
         </option>
      <?php } ?>
   </select><br>
   New Date: <input type="date" name="seminarDate"><br>
   New Start Time: <input type="time" name="startTime"><br>
   New End Time: <input type="time" name="endTime"><br>
   New Room Location: <input type="text" name="roomLocation"><br>
   <input type="submit" value="Update Session">
</form>

<?php
// Process form submission for updating sessions
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // retrieve selected seminar name
      $seminarName = $_POST['seminarName'];
      // prepare arrays for update clauses and parameters
      $updates = array();
      $params = array(':seminarName' => $seminarName);
      
      if (!empty($_POST['seminarDate'])) {
         // add seminarDate to updates
         $updates[] = "seminarDate = :seminarDate";
         $params[':seminarDate'] = $_POST['seminarDate'];
      }
      if (!empty($_POST['startTime'])) {
         // add startTime to updates
         $updates[] = "startTime = :startTime";
         $params[':startTime'] = $_POST['startTime'];
      }
      if (!empty($_POST['endTime'])) {
         // add endTime to updates
         $updates[] = "endTime = :endTime";
         $params[':endTime'] = $_POST['endTime'];
      }
      if (!empty($_POST['roomLocation'])) {
         // add roomLocation to updates
         $updates[] = "roomLocation = :roomLocation";
         $params[':roomLocation'] = $_POST['roomLocation'];
      }
      
      if ($updates) {
         // update seminar details if fields provided
         $query = "UPDATE seminar SET " . implode(", ", $updates) . " WHERE seminarName = :seminarName";
         $stmt = $connection->prepare($query);
         $stmt->execute($params);
         // inform user of successful update
         echo "<p>Session details for " . $seminarName . " updated successfully.</p>";
      } else {
         // display message when no updates are provided
         echo "<p>No updates provided.</p>";
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
