## Conference Management System
This repository contains a web application built using PHP/PDO and MySQL to enhance my database management skills. It automates operations for a theoretical university conference database, which I designed, supporting attendee management, session scheduling, sponsor/job listings, and financial reporting.

## Features

- Built server-side form handling for user input validation and data processing.
- Implemented secure database access using PDO with prepared statements.
- Created full CRUD interfaces for attendees, sessions, sponsors, and job ads.
- Developed dynamic SQL-driven dropdowns and HTML tables for live data display.
- Automated primary-key generation (attendeeID, jobAdID) to eliminate manual entry.
- Designed aggregate reports (GROUP BY, SUM, COUNT, GROUP_CONCAT) for registration, finance, and sponsorship breakdowns.
- Structured modular includes (database connection, shared components) for maintainable code.
- Used relative asset paths for images to ensure out-of-the-box portability.

## Tech Stack

- PHP 7+ with PDO
- MySQL
- XAAMP (Apache) web server
- HTML5

## Project Context
Developed as a solo project, this application is designed to be compatible with most database management systems (DBMS) and packaged for simple deployment — unzip, configure connectdb.php, and run. Creating this project enhanced my end-to-end web development abilities, including backend logic implementation, SQL querying, relational database design, and intuitive UI creation for managing and manipulating a conference database.
