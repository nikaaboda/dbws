<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $sql = "SELECT T.title, T.description, T.completed FROM Tasks T ORDER BY T.tid";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    if ($result->num_rows > 0) { 
?>
    <h2>Tasks</h2>
    <table>
        <thead>
            <tr style='text-align: center;'>
                <th>Title</th>
                <th>Description</th>
                <th>Completed</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?=$row['title']?></td>
                <td><?=$row['description']?></td>
                <td><?=$row['completed']?></td>
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
