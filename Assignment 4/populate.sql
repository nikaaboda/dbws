# Populate the TA portal with sample data
use portal;

INSERT INTO
	Users(
		firstname,
		lastname,
		email
	)
VALUES
	('Panthi', 'Bivek', 'p.bivek@jacobs-university.de'),
	('Nikolozi', 'Bodaveli', 'n.bodaveli@jacobs-university.de'),
	('Giorgi', 'Jabishvili', 'g.jabishvili@jacobs-university.de'),
	('Dmytro', 'Rudenko', 'd.rudenko@jacobs-university.de'),

	('Kinga', 'Lipskoch', 'k.lipskoch@jacobs-university.de'),
	('Juergen', 'Schoenwaelder', 'j.schoenwaelder@jacobs-university.de'),
	('Mattias', 'Ullrich', 'm.ullrich@jacobs-university.de'),
	('Keivan', 'Mallahi-Karai', 'k.karai@jacobs-university.de');

INSERT INTO
	TAStudents(
	    uid,
	    mnum,
	    semester,
	    major
	)
VALUES
	(1, '30004000', 3, 'Computer Science'),
	(2, '30004001', 3, 'Computer Science'),
	(3, '30004002', 3, 'Medicinal Chemistry and Chemical Biology'),
	(4, '30004003', 3, 'Mathematics');


INSERT INTO
	Professors(
	    uid,
	    profid,
	    faculty
	)
VALUES
	(5, '40004000', 'Computer Science'),
	(6, '40004001', 'Computer Science'),
	(7, '40004002', 'Medicinal Chemistry and Chemical Biology'),
	(8, '40004003', 'Mathematics');

INSERT INTO
	Contracts(
		contractid,
		startdate,
		enddate,
		mnum
	)
VALUES
	('contract#4000', '2021-09-01', '2021-12-01', '30004000'),
	('contract#4001', '2021-09-01', '2021-12-01', '30004001'),
	('contract#4002', '2021-09-01', '2021-12-01', '30004002'),
	('contract#4003', '2021-09-01', '2021-12-01', '30004003');

INSERT INTO
	Courses(
	    shortname,
	    longname
	)
VALUES
	('C/CPP', 'Introduction to C & C++'),
	('ICS', 'Introduction to Computer Science'),
	('MICROBIO', 'Micro Biology'),
	('ANLSS', 'Analysis I');


INSERT INTO
	Tasks(
	    title,
	    description
	)
VALUES
	('Grade homework #1', 'Grade all homeworks for the #1 assignment until tomorrow'),
	('Tutorial', 'Host a tutorial tomorrow in East Hall'),
	('Tutorial', 'Tutorial in West Hall');

INSERT INTO
	Homeworks(
	    tid,
	    deadline
	)
VALUES
	(1, '2021-09-07');

INSERT INTO
	Tutorials(
	    tid,
	    date,
	    starttime,
	    endtime
	)
VALUES
	(2, '2021-09-05', '00:11:00', '00:12:00'),
	(3, '2021-09-06', '00:19:00', '00:20:00');

INSERT INTO 
	Created(
	    profid,
	    tid
	)
VALUES
	('40004000', 1),
	('40004001', 2),
	('40004002', 3);

INSERT INTO
	Assigned_To(
		mnum,
		tid
	)
VALUES
	('30004000', 1),
	('30004001', 2),
	('30004002', 3);

INSERT INTO
	Teaches(
		profid,
		courseid
	)
VALUES
	('40004000', 1),
	('40004001', 2),
	('40004002', 3),
	('40004003', 4);

INSERT INTO
	TA_For(
		mnum,
		courseid,
		contractid
	)
VALUES
	('30004000', 1, 'contract#4000'),
	('30004001', 2, 'contract#4001'),
	('30004002', 3, 'contract#4002'),
	('30004003', 4, 'contract#4003');

INSERT INTO
	Belongs_To(
		tid,
		courseid
	)
VALUES
	(1, 1),
	(2, 2),
	(3, 3);


INSERT INTO
	Admins(
		aid,
		username,
		pass
	)
VALUES
	(1, "nboda", "green123"),
	(2, "lkvav", "purple123");