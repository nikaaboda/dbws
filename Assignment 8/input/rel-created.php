<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $tasks = $conn->query("SELECT * FROM Tasks");
    $professors = $conn->query("SELECT U.firstname, U.lastname, U.email, P.profid, P.faculty FROM Users U, Professors P WHERE U.uid = P.uid ORDER BY U.uid");
?>
<h2>Insert a new Created Relationship</h2>
<p>Create a new "Created" relationship between a "Professor" entity and a "Task" entity.</p>
<p>References: 
    <a href="<?=ROOT?>reference/professors.php" class="reference">Professors</a>
    <a href="<?=ROOT?>reference/tasks.php" class="reference">Tasks</a>
</p>
<form method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="profid">Professor:</label>
    <select name="profid" id="profid">
        <?php
            while ($row = $professors->fetch_assoc()) {
                echo "<option value='$row[profid]'>$row[firstname] $row[lastname]</option>";
            }
        ?>
    </select>
    <span class="must">*</span>

    <label for="tid">Task:</label>
    <select name="tid" id="tid">
        <?php
            while ($row = $tasks->fetch_assoc()) {
                echo "<option value='$row[tid]'>$row[title]</option>";
            }
        ?>
    </select>
    <span class="must">*</span>

    <label for="username">Username:</label>
    <input type="text" name="username" required></input>
    <span class="must">*</span>
    
    <label for="password">Password:</label>
    <input type="password" name="password" required></input>
    <span class="must">*</span>

    <button type="submit">
        Add
    </button>
</form>
</br>
</br>
</br>
<?php
    // Output the rest of the page and be done with this script
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    include_once(__DIR__ . '/../app/auth.php');
    passAuth($username, $password, $conn);

    $tid = mysqli_real_escape_string($conn, $_POST['tid']);
    $profid = mysqli_real_escape_string($conn, $_POST['profid']);
        
    $sql = "INSERT INTO Created (profid, tid) VALUES ('$profid', '$tid')";
    // Output the rest of the page and be done with this script
    if (!$conn->query($sql)) {
        echo "Insert error: " . mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    echo '<p class="success">A new realtionship was succesfully added to the teaches table!</p>';
    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php'); 
?>
