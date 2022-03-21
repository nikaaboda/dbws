<?php
    include_once(__DIR__ . '/../app/start.php');

    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $users = $conn->query("SELECT * FROM Users ORDER BY uid");
?>
<h2>Insert a new Student TA</h2>
<a href="<?=ROOT?>reference/students.php" class="reference">Reference</a>
<form method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="uid">User:</label>
    <select name="uid" id="uid">
        <?php
            while ($row = $users->fetch_assoc()) {
                echo "<option value='$row[uid]'>$row[firstname] $row[lastname] ($row[email])</option>";
            }
        ?>
    </select>
    <span class="must">*</span>

    <label for="matnum">Matriculation Number:</label>
    <input type="number" name="matnum" id="matnum" required/><span class="must">*</span>
    <br/>
    <label for="semester">Semester:</label>
    <input type="number" name="semester" id="semester" min=1 required/><span class="must">*</span>
    <br/>
    <label for="major">Major:</label>
    <select name="major" id="major" value="select" required>
        <option>Computer Science</option>
        <option>Robotics</option>
        <option>BCCB</option>
        <option>Psycology</option>
        <option>History</option>
        <option>Chemistry</option>
        <option>Mathematics</option>
    </select><span class="must">*</span>

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
    $uid = $major = $matnum = $semester = '';

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

    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $major = mysqli_real_escape_string($conn, $_POST['major']);
    $matnum = mysqli_real_escape_string($conn, $_POST['matnum']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);

    $sql = "INSERT INTO TAStudents (uid, mnum, semester, major) VALUES ('$uid','$matnum','$semester','$major')";
    if (!$conn->query($sql)) {
        echo "Insert error: " . mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    echo '<p class="success">Student was succesfully added to the TA table!</p>';
    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php'); 
?>
