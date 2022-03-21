<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $courses = $conn->query("SELECT * FROM Courses");
    $professors = $conn->query("SELECT U.firstname, U.lastname, U.email, P.profid, P.faculty FROM Users U, Professors P WHERE U.uid = P.uid ORDER BY U.uid");
?>
<h2>Insert a new Teaches Relationship</h2>
<p>Create a new "Teaches" relationship between a "Professor" entity and a "Course" entity.</p>
<p>References: 
    <a href="<?=ROOT?>reference/professors.php" class="reference">Professors</a>
    <a href="<?=ROOT?>reference/courses.php" class="reference">Courses</a>
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

    <label for="courseid">Course:</label>
    <select name="courseid" id="courseid">
        <?php
            while ($row = $courses->fetch_assoc()) {
                echo "<option value='$row[courseid]'>$row[longname]</option>";
            }
        ?>
    </select>
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

    $courseid = mysqli_real_escape_string($conn, $_POST['courseid']);
    $profid = mysqli_real_escape_string($conn, $_POST['profid']);
        
    $sql = "INSERT INTO Teaches (profid, courseid) VALUES ('$profid', '$courseid')";
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
