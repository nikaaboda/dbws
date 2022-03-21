<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $sql = "SELECT U.firstname, U.lastname, U.email, T.mnum, T.major, T.semester FROM Users U, TAStudents T WHERE U.uid = T.uid ORDER BY U.uid";
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
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Matriculation Number</th>
                <th>Major</th>
                <th>Semester</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?=$row['firstname']?></td>
                <td><?=$row['lastname']?></td>
                <td><?=$row['email']?></td>
                <td><?=$row['mnum']?></td>
                <td><?=$row['major']?></td>
                <td><?=$row['semester']?></td>
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
