<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect-readonly.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $courseid = '';
    if (isset($_GET['courseid'])) {
    	$courseid = mysqli_real_escape_string($conn, $_GET['courseid']);
    }

    $sql = "
        SELECT C.courseid, C.shortname, C.longname
        FROM Courses C
        WHERE
        	C.courseid = '$courseid'
        ORDER BY C.courseid
    ";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $course = $result->fetch_assoc();
    if (!$course) {
    	echo '<p class="error">That course was not found :(</p>';
    	include_once(__DIR__ . '/../app/end.php');
    	exit();
    }

    $professorsSql = "
    	SELECT P.profid, U.firstname, U.lastname, U.email, P.profid, P.faculty
    	FROM Users U, Professors P, Teaches T
    	WHERE U.uid = P.uid AND P.profid = T.profid AND T.courseid = '$courseid'
    	ORDER BY P.profid
    ";

    $tastudentsSql = "
    	SELECT U.firstname, U.lastname, U.email, T.mnum, T.semester, T.major
    	FROM Users U, TAStudents T, TA_For TA
    	WHERE U.uid = T.uid AND T.mnum = TA.mnum AND TA.courseid = '$courseid'
    	ORDER BY T.mnum
    ";

    $professors = $conn->query($professorsSql);
    $tastudents = $conn->query($tastudentsSql);
?>

<h2>Course profile (#<?=$courseid?>)</h2>

<h2><?=$course['longname']?></h2>

<br />
<br />
<h2>Professors that teach <?=$course['longname']?></h2>
<table>
	<thead>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Professors ID</th>
			<th>Faculty</th>
		</tr>
	</thead>
	<tbody>
		<?php
			while ($professor = $professors->fetch_assoc()) {
		?>
			<tr>
				<td><?=$professor['firstname']?></td>
				<td><?=$professor['lastname']?></td>
				<td><?=$professor['email']?></td>
				<td><?=$professor['profid']?></td>
				<td><?=$professor['faculty']?></td>
			</tr>
		<?php
			}
		?>
	</tbody>
</table>
<br />
<br />
<h2>TA's for <?=$course['longname']?></h2>
<table>
	<thead>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Matriculation Number</th>
			<th>Semester</th>
			<th>Major</th>
		</tr>
	</thead>
	<tbody>
		<?php
			while ($tastudent = $tastudents->fetch_assoc()) {
		?>
			<tr>
				<td><?=$tastudent['firstname']?></td>
				<td><?=$tastudent['lastname']?></td>
				<td><?=$tastudent['email']?></td>
				<td><?=$tastudent['mnum']?></td>
				<td><?=$tastudent['semester']?></td>
				<td><?=$tastudent['major']?></td>
			</tr>
		<?php
			}
		?>
	</tbody>
</table>

<?php
    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php');
?>
