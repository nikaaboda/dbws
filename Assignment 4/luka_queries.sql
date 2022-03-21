# Every TA + their corresponding course
SELECT
	CONCAT(U.firstname, ' ', U.lastname) AS 'TA Full Name',
	TA.mnum as 'TA Matriculation Number',
	C.longname as 'TA Course Name'
FROM
	Users U,
	TAStudent TA,
	Courses C,
	TA_For TF
WHERE
	U.uid = TA.uid AND
	TF.courseid = C.courseid AND
	TF.mnum = TA.mnum;

# Every professor + their course
SELECT
	CONCAT(U.firstname, ' ', U.lastname) AS 'Professor Full Name',
	P.profid as 'Professor ID',
	C.longname as 'Professor Course Name'
FROM
	Users U,
	Professors P,
	Courses C,
	Teaches TCH
WHERE
	U.uid = P.uid AND
	TCH.courseid = C.courseid AND
	TCH.profid = P.profid;
	