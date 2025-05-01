<?php
// Establish database connection
try {
    // create new PDO instance for conferenceDB
    $connection = new PDO('mysql:host=localhost;dbname=conferenceDB', "root", "");
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    // stop script execution
    die();
}
?>
