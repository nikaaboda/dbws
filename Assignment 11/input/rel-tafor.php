<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $courses = $conn->query("SELECT * FROM Courses");
    $students = $conn->query("SELECT U.firstname, U.lastname, U.email, T.mnum FROM Users U, TAStudents T WHERE U.uid = T.uid ORDER BY U.uid");
?>
<h2>Insert a new TA For Relationship</h2>
<p>Create a new "TA For" relationship between a "Student TA" entity and a "Course" entity that also references a "Contract" entity.</p>
<p>References: 
    <a href="<?=ROOT?>reference/students.php">TAStudents</a>
    <a href="<?=ROOT?>reference/courses.php">Courses</a>
    <a href="<?=ROOT?>reference/contracts.php">Contracts</a>
</p>
<form method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="mnum">Matriculation Number:</label>
    <select name="mnum" id="mnum">
        <?php
            while ($row = $students->fetch_assoc()) {
                echo "<option value='$row[mnum]'>$row[firstname] $row[lastname]</option>";
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

    <label for="contractid">Contract ID:</label>
    <input type="number" name="contractid" id="contractid" required/>

    <label for="sdate">Start Date</label>
    <input type="date" name="sdate" id="sdate" required/>

    <label for="sdate">End Date</label>
    <input type="date" name="edate" id="edate" required/>

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

    $courseid = mysqli_real_escape_string($conn, $_POST['courseid']);
    $sdate = mysqli_real_escape_string($conn, $_POST['sdate']);
    $edate = mysqli_real_escape_string($conn, $_POST['edate']);
    $mnum = mysqli_real_escape_string($conn, $_POST['mnum']);
        
    $sql = "INSERT INTO Contracts (contractid, startdate, enddate, mnum) VALUES ('$contractid', '$sdate', '$edate', '$mnum')";
    // Output the rest of the page and be done with this script
    if (!$conn->query($sql)) {
        echo "Insert error: " . mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    echo '<p class="success">A new contract was succesfully added to the contracts table!</p>';


    $sql = "INSERT INTO TA_For (contractid, mnum, courseid) VALUES ('$contractid', '$mnum', $courseid)";
    // Output the rest of the page and be done with this script
    if (!$conn->query($sql)) {
        echo "Insert error: " . mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    echo '<p class="success">A new TA_For relationship was succesfully added to the TA_For table!</p>';
    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php'); 
?>
