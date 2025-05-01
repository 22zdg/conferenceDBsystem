<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - Add Attendee</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';
?>

<h1>Add a New Attendee</h1>

<!-- Attendee form -->
<form action="add_attendee.php" method="post">
   Attendee Name: <input type="text" name="attendeeName" required><br>
   Type: 
      <input type="radio" name="type" value="student" required>Student
      <input type="radio" name="type" value="professional" required>Professional
      <input type="radio" name="type" value="sponsor" required>Sponsor<br>
   <?php
      //provide hotel room options for students
      $query = "SELECT roomNumber FROM hotelroom";
      $result = $connection->query($query);
   ?>

   For students, select a hotel room: 
   <select name="roomNumber">
      <option value="">None</option>
      <?php while ($row = $result->fetch()) { ?>
         <option value="<?php echo $row['roomNumber']; ?>"><?php echo $row['roomNumber']; ?></option>
      <?php } ?>
   </select><br>
   <?php
      // provide sponsoring company options for sponsors
      $query = "SELECT sponsorName FROM sponsoringCompany";
      $result = $connection->query($query);
   ?>

   For sponsors, select a sponsoring company: 
   <select name="sponsorName">
      <option value="">None</option>
      <?php while ($row = $result->fetch()) { ?>
         <option value="<?php echo $row['sponsorName']; ?>"><?php echo $row['sponsorName']; ?></option>
      <?php } ?>
   </select><br>
   <input type="submit" value="Add Attendee">
</form>

<?php
// Process form submission
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $attendeeName = $_POST['attendeeName'];
      $type         = $_POST['type'];

    // Ensure hotel room is only selected for students
    if ($type != 'student' && !empty($_POST['roomNumber'])) {
        echo "<p>Error: Hotel room selection is only allowed for student type.</p>";
        echo '<p><a href="conference.php">Return to Home</a></p>';
        exit;
    }

    // Ensure sponsoring company is only selected for sponsors
    if ($type != 'sponsor' && !empty($_POST['sponsorName'])) {
        echo "<p>Error: Sponsoring company selection is only allowed for sponsor type.</p>";
        echo '<p><a href="conference.php">Return to Home</a></p>';
        exit;
    }

    // If student is selected, ensure a hotel room is selected
    if ($type == 'student' && empty($_POST['roomNumber'])) {
        echo "<p>Error: For a student, you must select a hotel room. Please go back and choose one.</p>";
        echo '<p><a href="conference.php">Return to Home</a></p>';
        exit;
    }

    // If sponsor is selected, ensure a sponsoring company is selected
    if ($type == 'sponsor' && empty($_POST['sponsorName'])) {
        echo "<p>Error: For a sponsor, you must select a sponsoring company. Please go back and choose one.</p>";
        echo '<p><a href="conference.php">Return to Home</a></p>';
        exit;
    }

      // Assign new ID by finding the current maximum and adding one
      $query = "SELECT MAX(attendeeID) AS maxID FROM attendee";
      $result = $connection->query($query);
      $row = $result->fetch();
      $newAttendeeID = intval($row['maxID']) + 1;

    // Determine fee based on attendee type
    if ($type == 'student') {
        $fee = 50;
    } elseif ($type == 'professional') {
        $fee = 100;
    } elseif ($type == 'sponsor') {
        $fee = 0;
    }
      
      // Insert attendee record into database
      $query = "INSERT INTO attendee (attendeeID, type, fee, attendeeName)
                VALUES (:attendeeID, :type, :fee, :attendeeName)";
      $stmt = $connection->prepare($query);
      $stmt->execute(array(
         ':attendeeID'   => $newAttendeeID,
         ':type'         => $type,
         ':fee'          => $fee,
         ':attendeeName' => $attendeeName
      ));

      // If student, insert into student table
      if ($type == 'student') {
        $roomNumber = $_POST['roomNumber'];
        $query = "INSERT INTO student (attendeeID, roomNumber)
                  VALUES (:attendeeID, :roomNumber)";
        $stmt = $connection->prepare($query);
        $stmt->execute(array(
            ':attendeeID' => $newAttendeeID,
            ':roomNumber' => $roomNumber
         ));
      }
      
      // If sponsor, insert into sponsor table
      if ($type == 'sponsor') {
        $sponsorName = $_POST['sponsorName'];
        $query = "INSERT INTO sponsor (attendeeID, sponsorName)
                  VALUES (:attendeeID, :sponsorName)";
        $stmt = $connection->prepare($query);
        $stmt->execute(array(
            ':attendeeID'  => $newAttendeeID,
            ':sponsorName' => $sponsorName
        ));
      }

    // If professional, insert into professional table
    if ($type == 'professional') {
        $query = "INSERT INTO professional (attendeeID) VALUES (:attendeeID)";
        $stmt = $connection->prepare($query);
        $stmt->execute(array(':attendeeID' => $newAttendeeID));
    }
      
      // Display success message
      echo "<p>New attendee added successfully! ID: " . $newAttendeeID . " and Fee: $" . $fee . "</p>";
   }
   $connection = NULL;
?>

<!-- Link back to home page -->
<p>
   <a href="conference.php">Return to Home</a>
</p>
</body>
</html>