<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $sql = "
        SELECT C.contractid, U.firstname, U.lastname, C.startdate, C.enddate
        FROM Contracts C, Users U, TAStudents T
        WHERE C.mnum = T.mnum AND T.uid = U.uid
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
    <h2>Students</h2>
    <table>
        <thead>
            <tr style='text-align: center;'>
                <th>Contract ID</th>
                <th>TA Student</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?=$row['contractid']?></td>
                <td><?=$row['firstname']?> <?=$row['lastname']?></td>
                <td><?=$row['startdate']?></td>
                <td><?=$row['enddate']?></td>
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
