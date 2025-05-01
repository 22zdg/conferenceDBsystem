drop database if exists conferenceDB;
create database conferenceDB;
use conferenceDB;

-- committeeMember table (strong entity)
create table committeeMember(
    committeeMemberID int primary key,
    memberName varchar(100) not null
);

-- process strong entities
-- subCommittee table (strong entity)
create table subCommittee(
    subCommitteeName varchar(100) primary key,
    chairID int not null,
    foreign key (chairID) references committeeMember(committeeMemberID)
);
    
-- seminar table (strong entity)
-- note: changed name of entity from 'session' to 'seminar' to avoid using a mysql reserved keyword as per best practice
create table seminar(
    seminarName varchar(100) primary key,
    roomLocation varchar(300) not null,
    seminarDate date not null,
    startTime time not null,
    endTime time not null
);

-- sponsoringCompany (strong entity)
create table sponsoringCompany(
    sponsorName varchar(100) primary key,
    amountPaid int not null,
    -- note: name of attribute "level" changed to "tier" to avoid using a mysql reserved keyword as per best practice
    tier enum('bronze','silver','gold','platinum') not null,
    emailsSent int,
    emailsAllowed int not null
);
    
-- jobAd table (weak entity)
create table jobAd (
    sponsorName varchar(100) not null, -- foreign key from sponsoringCompany
    jobAdID int not null,              -- partial key for jobAd
    jobTitle varchar(100) not null,
    payRate int not null,
    city varchar(100) not null,
    street varchar(100) not null,
    postalCode char(10) not null,
    primary key (sponsorName, jobAdID),
    foreign key (sponsorName) references sponsoringCompany(sponsorName) on delete cascade
);
    
-- hotelroom (strong entity)
create table hotelroom(
    roomNumber int primary key,
    numberOfBeds int not null
);
    
-- attendee table (strong entity, super-entity for specialization)
create table attendee(
    attendeeID int primary key,
    type enum('student','professional','sponsor') not null,
    fee int,
    attendeeName varchar(100) not null
);

-- process specialization hierarchy
-- student table (specialization of attendee)
create table student (
    attendeeID int primary key,  -- same as attendee's primary key
    roomNumber int,
    foreign key (attendeeID) references attendee(attendeeID) on delete cascade, -- removing the attendee removes the student
    foreign key (roomNumber) references hotelroom(roomNumber) on delete set null -- when removing room, student's roomnumber becomes NULL
);

-- professional table (specialization of attendee)
create table professional(
    attendeeID int primary key,
    foreign key (attendeeID) references attendee(attendeeID) on delete cascade
);

-- sponsor table (specialization of attendee)
create table sponsor(
    attendeeID int primary key,
    sponsorName varchar(100) not null,
    foreign key (attendeeID) references attendee(attendeeID) on delete cascade,
    foreign key (sponsorName) references sponsoringCompany(sponsorName) on delete cascade
);
    
-- process many-to-many relationships
-- speaksAt: relationship between attendee (as speakers) and seminar
create table speaksAt(
    attendeeID int not null,
    seminarName varchar(100) not null,
    primary key (attendeeID, seminarName),
    foreign key (attendeeID) references attendee(attendeeID) on delete cascade,
    foreign key (seminarName) references seminar(seminarName) on delete cascade
);
    
-- hasMembers: relationship between subCommittee and committeeMember (for organizing committee membership)
create table hasMembers(
    subCommitteeName varchar(100) not null,
    committeeMemberID int not null,
    isChair boolean not null default 0,
    primary key (subCommitteeName, committeeMemberID),
    foreign key (subCommitteeName) references subCommittee(subCommitteeName) on delete cascade,
    foreign key (committeeMemberID) references committeeMember(committeeMemberID) on delete cascade
);
    
-- process multi-valued attributes
-- committeeMemberEmail (multi-valued attribute for committeeMember)
create table committeeMemberEmail(
    committeeMemberID int not null, -- foreign key from committeeMember
    email varchar(100) not null, -- multi-valued attribute
    primary key (committeeMemberID, email),
    foreign key (committeeMemberID) references committeeMember(committeeMemberID) on delete cascade
);
    
-- attendeeEmail (multi-valued attribute for attendee)
create table attendeeEmail(
    attendeeID int not null,
    email varchar(100) not null,
    primary key (attendeeID, email),
    foreign key (attendeeID) references attendee(attendeeID) on delete cascade
);

-- insert data
-- committeeMember
insert into committeeMember (committeeMemberID, memberName)
values
  (100, 'Alice Smith'),
  (101, 'Bob Johnson'),
  (102, 'Carol Lee'),
  (103, 'David Wright'),
  (104, 'Evelyn Hart'),
  (105, 'Frank Lopez');

-- subCommittee (requires existing committeeMember for chairID)
insert into subCommittee (subCommitteeName, chairID)
values
  ('Finance', 100),
  ('Logistics', 101),
  ('Publicity', 102),
  ('Speakers', 103),
  ('Registration', 104),
  ('Awards', 105);

-- seminar
insert into seminar (seminarName, roomLocation, seminarDate, startTime, endTime)
values
  ('Keynote', 'Main Hall', '2025-03-10', '09:00:00', '10:00:00'),
  ('TechTrends', 'Room A', '2025-03-10', '10:15:00', '11:15:00'),
  ('AI & Future', 'Room B', '2025-03-10', '11:30:00', '12:30:00'),
  ('Startup Pitch', 'Main Hall', '2025-03-10', '13:30:00', '15:00:00'),
  ('Cloud Computing', 'Room C', '2025-03-11', '09:00:00', '10:30:00'),
  ('Data Security', 'Room A', '2025-03-11', '10:45:00', '12:15:00');

-- sponsoringCompany
insert into sponsoringCompany (sponsorName, amountPaid, tier, emailsSent, emailsAllowed)
values
  ('TechCorp', 1000, 'bronze', 0, 0),
  ('CloudNet', 1000, 'bronze', 0, 0),
  ('DataSecure', 3000, 'silver', 2, 3),
  ('AIWorld', 5000, 'gold', 2, 4),
  ('StartupHub', 5000, 'gold', 3, 4),
  ('GreenEnergy', 10000, 'platinum', 5, 5);

-- hotelroom
insert into hotelroom (roomNumber, numberOfBeds)
values
  (201, 2),
  (202, 2),
  (203, 1),
  (204, 2),
  (205, 1),
  (206, 2);

-- attendee
insert into attendee (attendeeID, type, fee, attendeeName)
values
  (1, 'student', 50, 'George Miller'),
  (2, 'student', 50, 'Hannah Kim'),
  (3, 'professional', 100, 'Ian Thompson'),
  (4, 'professional', 100, 'Julia Chen'),
  (5, 'sponsor', 0, 'Kevin Rogers'),
  (6, 'sponsor', 0, 'Linda Brown'),
  (7, 'sponsor', 0, 'Henry Cook'),
  (8, 'sponsor', 0, 'Michael Scott'),
  (9, 'sponsor', 0, 'Jenna White'),
  (10, 'sponsor', 0, 'April Smith'),
  (11, 'sponsor', 0, 'Gabi Rose'),
  (12, 'sponsor', 0, 'Jon Snow'),
  (13, 'student', 50, 'Sansa Stark'),
  (14, 'student', 50, 'Mark Rover'),
  (15, 'professional', 100, 'Ben Hammond');

-- jobAd
insert into jobAd (sponsorName, jobAdID, jobTitle, payRate, city, street, postalCode)
values
  ('TechCorp', 1, 'Software Engineer', 45, 'San Francisco', '123 Market St', '94105'),
  ('TechCorp', 2, 'Data Analyst', 40, 'San Francisco', '123 Market St', '94105'),
  ('CloudNet', 1, 'Cloud Specialist', 50, 'New York', '456 5th Ave', '10001'),
  ('DataSecure', 1, 'Cybersecurity Intern', 30, 'Boston', '789 Freedom Rd', '02110'),
  ('AIWorld', 1, 'AI Researcher', 60, 'Seattle', '101 Innovation Way', '98101'),
  ('GreenEnergy', 1, 'Sustainability Analyst', 35, 'Denver', '202 Green Blvd', '80202');

-- student
insert into student (attendeeID, roomNumber)
values
  (1, 201),
  (2, 203),
  (13, 201),
  (14, 206);

-- professional
insert into professional (attendeeID)
values
  (3),
  (4),
  (15);

-- sponsor
insert into sponsor (attendeeID, sponsorName)
values
  (5, 'CloudNet'),
  (6, 'StartupHub'),
  (7, 'DataSecure'),
  (8, 'AIWorld'),
  (9, 'DataSecure'),
  (10, 'TechCorp'),
  (11, 'TechCorp'),
  (12, 'GreenEnergy');

-- speaksAt
insert into speaksAt (attendeeID, seminarName)
values
  (1, 'Keynote'),
  (3, 'TechTrends'),
  (3, 'AI & Future'),
  (4, 'Startup Pitch'),
  (5, 'Cloud Computing'),
  (6, 'Data Security');

-- hasMembers
insert into hasMembers (subCommitteeName, committeeMemberID, isChair)
values
  ('Finance', 100, 1),
  ('Finance', 101, 0),
  ('Logistics', 101, 1),
  ('Publicity', 102, 1),
  ('Speakers', 103, 1),
  ('Registration', 104, 1);

-- committeeMemberEmail
insert into committeeMemberEmail (committeeMemberID, email)
values
  (100, 'alice.smith@example.com'),
  (100, 'alice.smith@work.com'),
  (101, 'bob.johnson@example.com'),
  (102, 'carol.lee@example.com'),
  (103, 'david.wright@example.com'),
  (104, 'evelyn.hart@work.com'),
  (105, 'frank.lopez@example.com');

-- attendeeEmail
insert into attendeeEmail (attendeeID, email)
values
  (1, 'george.miller@school.edu'),
  (2, 'hannah.kim@school.edu'),
  (3, 'ian.thompson@company.com'),
  (4, 'julia.chen@company.com'),
  (5, 'kevin.rogers@sponsor.org'),
  (6, 'linda.brown@sponsor.org'),
  (7, 'henry.cook@sponsorsuite.com'),
  (8, 'm.scott@sponsorsuite.com'),
  (9, 'jenna.white@sponsorsuite.com'),
  (10, 'april.smith@sponsorsuite.com'),
  (11, 'gabi.rose@sponsorsuite.com'),
  (12, 'jon.snow@sponsorsuite.com'),
  (13, 'sansa.stark@studenthub.edu'),
  (14, 'mark.rover@studenthub.edu'),
  (15, 'b.hammond@proconnect.net'),
  (15, 'ben.h@proconnect.net');