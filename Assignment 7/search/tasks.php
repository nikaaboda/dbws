<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $where = "T.tid = T.tid";
    $fields = [
        'title',
        'description',
        'completed'
    ];

    foreach ($fields as $field) {
        if (isset($_GET[$field])) {
            $value = mysqli_real_escape_string($conn, $_GET[$field]);

            //convert No to 0 and Yes to 1
            if($field == 'completed') {
                if($value == "no" || $value == "No") {
                    $value = 0;
                } else if($value == "yes" || $value == "Yes") {
                    $value = 1;
                }
            }

            $where .= " AND $field LIKE '%{$value}%'";
        }
    }

    $sql = "
        SELECT T.title, T.description, T.completed, T.tid
        FROM Tasks T
        WHERE $where
        ORDER BY T.tid
    ";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

?>
    <h2>Search for Tasks</h2>
    <h3>
        Filter
    </h3>
    <form method='GET' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" />
        <br/>

        <label for="description">Description:</label>
        <input type="text" name="description" id="description" />
        <br/>

        <label for="completed">Completed:</label>
        <input type="text" name="completed" id="completed" />
        <br/>
        <br/>

        <button type="submit">
            Filter
        </button>
    </form>
    <br />
    <br />
    <?php
        if ($result->num_rows > 0) { 
    ?>
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
                <td>
                    <a href="<?=ROOT?>view/task.php?tid=<?=$row['tid']?>">
                        <?=$row['title']?>
                    </a> 
                </td>
                <td><?=$row['description']?></td>
                <td><?=$row['completed'] == '0' ? 'No' : 'Yes'?></td>
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