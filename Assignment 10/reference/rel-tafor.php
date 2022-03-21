<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $sql = "
        SELECT
            U.firstname, U.lastname, TA.mnum, C.longname, Co.contractid, Co.startdate, Co.enddate
        FROM Users U, TAStudents TA, TA_For TAF, Courses C, Contracts Co WHERE
           TAF.mnum = TA.mnum AND TAF.courseid = C.courseid AND U.uid = TA.uid
        ORDER BY Co.contractid
    ";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    if ($result->num_rows > 0) { 
?>
    <table>
        <thead>
            <tr style='text-align: center;'>
                <th>TA</th>
                <th>Matriculation Number</th>
                <th>Course</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Contract ID</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?=$row['firstname']?> <?=$row['lastname']?></td>
                <td><?=$row['mnum']?></td>
                <td><?=$row['longname']?></td>
                <td><?=$row['startdate']?></td>
                <td><?=$row['enddate']?></td>
                <td><?=$row['contractid']?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php
    } else {
?>
    <h2>No Entries</h2>
<?php
    }

    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php');
?>
