<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $sql = "
        SELECT C.shortname, T.title, T.description
        FROM Belongs_To B, Courses C, Tasks T
        WHERE B.tid = T.tid AND B.courseid = C.courseid
        ORDER BY B.tid
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
    <h2>Belongs_To relationship (Tasks -> Courses)</h2>
    <table>
        <thead>
            <tr style='text-align: center;'>
                <th>Task Title</th>
                <th>Task Description</th>
                <th>Course Short Name</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?=$row['title']?></td>
                <td><?=$row['description']?></td>
                <td><?=$row['shortname']?></td>
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
