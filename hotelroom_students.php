<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - Hotel Room Students</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';
   
// Get list of hotel rooms
   $query = "SELECT roomNumber FROM hotelroom";
   $result = $connection->query($query);
   $rooms = $result->fetchAll();
?>
<h1>Students in a Hotel Room</h1>

<!-- Room selection form -->
<form action="hotelroom_students.php" method="post">
   <label for="roomNumber">Select Room Number:</label>
   <select name="roomNumber" id="roomNumber">
      <?php foreach ($rooms as $room) { ?>
         <option value="<?php echo $room['roomNumber']; ?>">
            <?php echo $room['roomNumber']; ?>
         </option>
      <?php } ?>
   </select>
   <input type="submit" value="Show Students">
</form>

<?php
// Process form submission for selected room
   if (isset($_POST['roomNumber'])) {
      $roomNumber = $_POST['roomNumber'];
    
      // query students assigned to the selected room
      $query = "SELECT a.attendeeID, a.attendeeName 
                FROM attendee a 
                JOIN student s ON a.attendeeID = s.attendeeID 
                WHERE s.roomNumber = :roomNumber";
      $stmt = $connection->prepare($query);
      $stmt->execute(array(':roomNumber' => $roomNumber));
      $students = $stmt->fetchAll();
      
      if ($students) {
         // display table of students in the room
         echo "<h2>Students in Room " . $roomNumber . ":</h2>";
         echo "<table border='1'>";
         echo "<tr><th>Attendee ID</th><th>Name</th></tr>";
         foreach ($students as $student) {
            echo "<tr>";
            echo "<td>" . $student['attendeeID'] . "</td>";
            echo "<td>" . $student['attendeeName'] . "</td>";
            echo "</tr>";
         }
         echo "</table>";
      } else {
         // display message if no students found
         echo "<p>No students found in room " . $roomNumber . ".</p>";
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
