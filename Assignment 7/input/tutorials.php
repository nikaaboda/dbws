<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $tasks = $conn->query("SELECT tid, title FROM Tasks");
    if (!$tasks) {
        echo mysqli_error($conn);
        die();
    }
?>
<h2>Insert a new Tutorial</h2>
<a href="<?=ROOT?>reference/tutorials.php" class="reference">Reference</a>
<form method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="tid">Associated task:</label>
    <select id="tid" name="tid">
        <?php
            while ($row = $tasks->fetch_assoc()) {
                echo "<option value='$row[tid]'>$row[title]</option>";
            }
        ?>
    </select>
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required placeholder="yyyy-mm-dd"/>
    <span class="must">*</span>
    <br />
    <label for="starttime">Start time:</label>
    <input type="text" name="starttime" id="starttime" required placeholder="hh:mm:ss"/>
    <span class="must">*</span>
    <br />
    <label for="endtime">End time:</label>
    <input type="text" name="endtime" id="endtime" required placeholder="hh:mm:ss"/>
    <span class="must">*</span>
    <button type="submit">
        Add
    </button>
</form>
</br>
</br>
</br>
<?php
    $tid = $date = $starttime = $endtime = '';

    // Output the rest of the page and be done with this script
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $tid = mysqli_real_escape_string($conn, $_POST['tid']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $starttime = mysqli_real_escape_string($conn, $_POST['starttime']);
    $endtime = mysqli_real_escape_string($conn, $_POST['endtime']);
        
    $sql = "INSERT INTO Tutorials (tid, date, starttime, endtime) VALUES ('$tid', '$date', '$starttime', '$endtime')";
    // Output the rest of the page and be done with this script
    if (!$conn->query($sql)) {
        echo "Insert error: " . mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    echo '<p class="success">Tutorial was succesfully added to the tutorials table!</p>';
    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php'); 
?>
