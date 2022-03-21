<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect-readonly.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $tid = '';
    if (isset($_GET['tid'])) {
    	$tid = mysqli_real_escape_string($conn, $_GET['tid']);
    }

    $sql = "
        SELECT T.title, T.description, T.completed, T.tid
        FROM Tasks T
        WHERE T.tid = '$tid'
    ";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $task = $result->fetch_assoc();
    if (!$task) {
    	echo '<p class="error">That task was not found :(</p>';
    	include_once(__DIR__ . '/../app/end.php');
    	exit();
    }

    $coursesSql = "
    	SELECT C.shortname, C.longname, C.courseid, B.tid, B.courseid
    	FROM Belongs_To B, Courses C
    	WHERE
    		B.tid = '$tid'
    		AND B.courseid = C.courseid
    	ORDER BY C.courseid
    ";

    $tasSql = "
    	SELECT TA.mnum, TA.uid, A.tid, A.mnum , U.uid, U.firstname, U.lastname, U.email
    	FROM TAStudents TA, Assigned_To A, Users U
    	WHERE
            U.uid = TA.uid
    		AND A.tid = '$tid'
    		AND A.mnum = TA.mnum
        ORDER BY TA.mnum
    ";

    $professorSql = "
		SELECT P.uid, P.profid, C.tid, C.profid, U.uid, U.firstname, U.lastname
		FROM Professors P, Created C, Users U 
        WHERE
            U.uid = P.uid
            AND C.tid = '$tid'
            AND C.profid = P.profid
        ORDER BY P.profid
	";

    $courses = $conn->query($coursesSql) or die($conn->error);
    $tas = $conn->query($tasSql) or die($conn->error);
    $professor = $conn->query($professorSql) or die($conn->error);
    $professor = $professor->fetch_assoc();
?>

<h2>Task's profile</h2>
<br />

    <h2>Task was created by the professor <?=$professor['firstname']?> <?=$professor['lastname']?></h2>

<br />
<br />

<h2>List of TA to whom this this task is assigned to</h2>
<table>
	<thead>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
		</tr>
	</thead>
	<tbody>
		<?php
			while ($ta = $tas->fetch_assoc()) {
		?>
			<tr>
				<td><?=$ta['firstname']?></td>
				<td><?=$ta['lastname']?></td>
				<td><?=$ta['email']?></td>
			</tr>
		<?php
			}
		?>
	</tbody>
</table>

<br />
<br />

<h2>List of courses this task belongs to</h2>
<table>
	<thead>
		<tr>
			<th>Course Short Name</th>
			<th>Course Long Name</th>
		</tr>
	</thead>
	<tbody>
		<?php
			while ($course = $courses->fetch_assoc()) {
		?>
			<tr>
				<td><?=$course['shortname']?></td>
				<td><?=$course['longname']?></td>
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