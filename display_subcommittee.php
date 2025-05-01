<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference - Sub-Committee Members</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';
   
// Get list of sub-committees
   $query = "SELECT subCommitteeName FROM subCommittee";
   $result = $connection->query($query);
   $subCommittees = $result->fetchAll();
?>

<h1>Display Sub-Committee Members</h1>

<!-- Sub-committee selection form -->
<form action="display_subcommittee.php" method="post">
   <label for="subCommitteeName">Choose a Sub-Committee:</label>
   <select name="subCommitteeName" id="subCommitteeName">
      <?php foreach ($subCommittees as $sc) { ?>
         <option value="<?php echo $sc['subCommitteeName']; ?>">
            <?php echo $sc['subCommitteeName']; ?>
         </option>
      <?php } ?>
   </select>
   <input type="submit" value="Show Members">
</form>

<?php
// Process form submission for display sub-committee members
   if (isset($_POST['subCommitteeName'])) {
      $subCommitteeName = $_POST['subCommitteeName'];
      
      // query members and their emails for selected sub-committee
      $query = "
         SELECT cm.committeeMemberID, cm.memberName, hm.isChair, 
                GROUP_CONCAT(cme.email SEPARATOR '<br>') AS emails
         FROM committeeMember cm 
         JOIN hasMembers hm ON cm.committeeMemberID = hm.committeeMemberID 
         LEFT JOIN committeeMemberEmail cme ON cm.committeeMemberID = cme.committeeMemberID
         WHERE hm.subCommitteeName = ?
         GROUP BY cm.committeeMemberID, cm.memberName, hm.isChair
      ";
      $stmt = $connection->prepare($query);
      $stmt->execute(array($subCommitteeName));
      $members = $stmt->fetchAll();
      
      if ($members) {
         // display members table
         echo "<h3>Members of " . $subCommitteeName . ":</h3>";
         echo "<table border='1'>";
         echo "<tr><th>ID</th><th>Name</th><th>Chair?</th><th>Email(s)</th></tr>";
         foreach ($members as $member) {
            // output each member row
            echo "<tr>";
            echo "<td>" . $member['committeeMemberID'] . "</td>";
            echo "<td>" . $member['memberName'] . "</td>";
            echo "<td>" . ($member['isChair'] ? 'Yes' : 'No') . "</td>";
            echo "<td>" . $member['emails'] . "</td>";
            echo "</tr>";
         }
         echo "</table>";
      } else {
         // display message when no members found
         echo "<p>No members found for " . $subCommitteeName . ".</p>";
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
