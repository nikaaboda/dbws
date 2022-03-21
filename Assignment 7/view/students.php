<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $mnum = '';
    if (isset($_GET['mnum'])) {
    	$mnum = mysqli_real_escape_string($conn, $_GET['mnum']);
    }

    $sql = "
        SELECT U.firstname, U.lastname, U.email, T.mnum, T.major
        FROM Users U, TAStudents T
        WHERE
        	T.mnum = '$mnum'
        	AND T.uid = U.uid
        ORDER BY U.uid
    ";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $student = $result->fetch_assoc();
    if (!$student) {
    	echo '<p class="error">That Student TA was not found :(</p>';
    	include_once(__DIR__ . '/../app/end.php');
    	exit();
    }

    $coursesSql = "
    	SELECT C.shortname, C.longname
    	FROM TA_For T, Courses C
    	WHERE
    		T.mnum = '$mnum'
    		AND T.courseid = C.courseid
    	ORDER BY C.courseid
    ";

    $tasksSql = "
    	SELECT T.title, T.description, T.completed
    	FROM Assigned_To A, Tasks T
    	WHERE
    		A.mnum = '$mnum'
    		AND A.tid = T.tid
    	ORDER BY T.tid
    ";

    $courses = $conn->query($coursesSql);
    $tasks = $conn->query($tasksSql);
?>

<h2>Student TA profile (#<?=$mnum?>)</h2>
<p>
	<b><?=$student['firstname']?> <?=$student['lastname']?></b>
	is majoring in <?=$student['major']?>.
	You can reach them at <a href="mailto:<?=$student['email']?>"><?=$student['email']?></a>
</p>
<br />
<br />
<h2><?=$student['firstname']?> <?=$student['lastname']?> is a TA for</h2>
<table>
	<thead>
		<tr>
			<th>Short Name</th>
			<th>Long Name</th>
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
<br />
<br />
<h2>Tasks assigned to <?=$student['firstname']?> <?=$student['lastname']?></h2>
<table>
	<thead>
		<tr>
			<th>Task Title</th>
			<th>Task Description</th>
			<th>Completed</th>
		</tr>
	</thead>
	<tbody>
		<?php
			while ($task = $tasks->fetch_assoc()) {
		?>
			<tr>
				<td><?=$task['title']?></td>
				<td><?=$task['description']?></td>
				<td><?=$task['completed'] == '0' ? 'No' : 'Yes'?></td>
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
