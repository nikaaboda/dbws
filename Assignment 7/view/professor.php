<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $profid = '';
    if (isset($_GET['profid'])) {
    	$profid = mysqli_real_escape_string($conn, $_GET['profid']);
    }

    $sql = "
        SELECT P.profid, U.firstname, U.lastname, U.email, P.profid, P.faculty
        FROM Users U, Professors P
        WHERE
        	P.profid = '$profid'
        	AND P.uid = U.uid
        ORDER BY U.uid
    ";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $professor = $result->fetch_assoc();
    if (!$professor) {
    	echo '<p class="error">That professor was not found :(</p>';
    	include_once(__DIR__ . '/../app/end.php');
    	exit();
    }

    $coursesSql = "
    	SELECT C.shortname, C.longname
    	FROM Teaches T, Courses C
    	WHERE
    		T.profid = '$profid'
    		AND T.courseid = C.courseid
    	ORDER BY C.courseid
    ";

    $tasksSql = "
    	SELECT T.title, T.description, T.completed
    	FROM Created C, Tasks T
    	WHERE
    		C.profid = '$profid'
    		AND C.tid = T.tid
    	ORDER BY T.tid
    ";

    $courses = $conn->query($coursesSql);
    $tasks = $conn->query($tasksSql);
?>

<h2>Professor profile (#<?=$profid?>)</h2>
<p>
	<b><?=$professor['firstname']?> <?=$professor['lastname']?></b>
	is a part of the <?=$professor['faculty']?> factuly.
	You can reach them at <a href="mailto:<?=$professor['email']?>"><?=$professor['email']?></a>
</p>
<br />
<br />
<h2>Courses taught by <?=$professor['firstname']?> <?=$professor['lastname']?></h2>
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
<h2>Tasks created by <?=$professor['firstname']?> <?=$professor['lastname']?></h2>
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
