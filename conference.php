<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Conference</title>
</head>
<body>
<?php
// Include database connection
   include 'connectdb.php';
?>

<h1>Welcome to the Conference Management System</h1>
<h2>Select an option:</h2>
<nav>
   <!-- link to view sub-committee members -->
   <a href="display_subcommittee.php">Sub-Committee Members</a> |

   <!-- link to view students with hotel rooms -->
   <a href="hotelroom_students.php">Hotel Room Students</a> |

   <!-- link to view conference schedule -->
   <a href="conference_schedule.php">Conference Schedule</a> |

   <!-- link to view sponsors list -->
   <a href="sponsors.php">Sponsors</a> |

   <!-- link to view jobs by company -->
   <a href="company_jobs.php">Company Jobs</a> |

   <!-- link to view all job listings -->
   <a href="all_jobs.php">All Jobs</a> |

   <!-- link to view all attendees -->
   <a href="attendees.php">Attendees List</a> |

   <!-- link to add a new attendee -->
   <a href="add_attendee.php">Add Attendee</a> |

   <!-- link to view conference intake totals -->
   <a href="conference_intake.php">Conference Intake</a> |

   <!-- link to add a sponsoring company -->
   <a href="add_company.php">Add Sponsoring Company</a> |

   <!-- link to delete a sponsoring company -->
   <a href="delete_company.php">Delete Sponsoring Company</a> |

   <!-- link to update a session -->
   <a href="update_session.php">Update Session</a> |
   
   <!-- link to add a job listing -->
   <a href="add_job.php">Add Job</a>
</nav>
<p>
   <!-- display conference image -->
   <img src="images/conference_image.png" alt="Conference" width="300">
</p>

<?php
   $connection = NULL;
?>
</body>
</html>
