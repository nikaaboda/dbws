<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $tasks = $conn->query("SELECT * FROM Tasks");
    $courses = $conn->query("SELECT * FROM Courses");
?>
<h2>Insert a new BelongsTo Relationship</h2>
<p>Create a new "BelongsTo" relationship between a "Course" entity and a "Task" entity.</p>
<p>References: 
    <a href="<?=ROOT?>reference/courses.php" class="reference">Courses</a>
    <a href="<?=ROOT?>reference/tasks.php" class="reference">Tasks</a>
</p>
<form method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="tid">Task:</label>
    <select name="tid" id="tid">
        <?php
            while ($row = $tasks->fetch_assoc()) {
                echo "<option value='$row[tid]'>$row[title]</option>";
            }
        ?>
    </select>
    <span class="must">*</span>

    <label for="courseid">Course:</label>
    <select name="courseid" id="courseid">
        <?php
            while ($row = $courses->fetch_assoc()) {
                echo "<option value='$row[courseid]'>$row[longname]</option>";
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
    $courseid = mysqli_real_escape_string($conn, $_POST['courseid']);
        
    $sql = "INSERT INTO Belongs_To (tid, courseid) VALUES ('$tid', '$courseid')";
    // Output the rest of the page and be done with this script
    if (!$conn->query($sql)) {
        echo "Insert error: " . mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    echo '<p class="success">A new realtionship was succesfully added to the belongs_to table!</p>';
    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php'); 
?>
