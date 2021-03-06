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
<h2>Insert a new Professor</h2>
<a href="<?=ROOT?>reference/professors.php" class="reference">Reference</a>
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

    <label for="profid">Professor Id:</label>
    <input type="number" name="profid" id="profid" required/><span class="must">*</span>
    <br/>
    <label for="faculty">Faculty:</label>
    <select name="faculty" id="faculty" value="select" required>
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
    $uid = $faculty = $profid = '';

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
    $profid = mysqli_real_escape_string($conn, $_POST['profid']);
    $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);
        
    $sql = "INSERT INTO Professors (uid, profid, faculty) VALUES ('$uid','$profid','$faculty')";
    if (!$conn->query($sql)) {
        echo "Insert error: " . mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    echo '<p class="success">Professor was succesfully added to the Professors table!</p>';
    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php'); 
?>
