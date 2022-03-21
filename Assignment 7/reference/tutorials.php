<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $sql = "SELECT TU.date, TU.starttime, TU.endtime, T.title, T.description FROM Tutorials TU, Tasks T WHERE TU.tid = T.tid";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    if ($result->num_rows > 0) { 
?>
    <h2>Tutorials</h2>
    <table>
        <thead>
            <tr style='text-align: center;'>
                <th>Date</th>
                <th>Time</th>
                <th>Title</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?=$row['date']?></td>
                <td><?=$row['starttime']?> - <?=$row['endtime']?></td>
                <td><?=$row['title']?></td>
                <td><?=$row['description']?></td>
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
