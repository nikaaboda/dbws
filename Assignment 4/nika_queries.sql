# Number of TAs per major
SELECT
	TA.major as 'Major',
	COUNT(*) as 'Number of TAs per major'
FROM
	TAStudent TA
GROUP BY
	TA.major;

# Every TA that has a tutorial and their corresponding tutorials
SELECT
	CONCAT(U.firstname, ' ', U.lastname) AS 'TA Full Name',
	TA.mnum as 'TA Matriculation Number',
	T.starttime as 'Tutorial Start time',
	T.endtime as 'Tutorial End time'
FROM
	Users U,
	TAStudent TA,
	Tutorials T,
	Assigned_To ATO,
	Tasks TK
WHERE
	U.uid = TA.uid AND
	TA.mnum = ATO.mnum AND
	ATO.tid = TK.tid AND
	T.tid = TK.tid;