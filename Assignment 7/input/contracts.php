<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $students = $conn->query("SELECT U.firstname, U.lastname, T.mnum FROM Users U, TAStudents T WHERE U.uid = T.uid ORDER BY U.uid");
?>
<h2>Insert a new Contract</h2>
<a href="<?=ROOT?>reference/contracts.php" class="reference">Reference</a>
<form method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="mnum">TA Student:</label>
    <select name="mnum" id="mnum">
        <?php
            while ($row = $students->fetch_assoc()) {
                echo "<option value='$row[mnum]'>$row[firstname] $row[lastname]</option>";
            }
        ?>
    </select>
    <span class="must">*</span>

    <label for="contractid">Contract ID:</label>
    <input type="text" name="contractid" id="contractid" required placeholder="xxxxxxx" />
    <span class="must">*</span>

    <label for="startdate">Start Date:</label>
    <input type="date" name="startdate" id="startdate" required placeholder="yyyy-mm-dd" />
    <span class="must">*</span>
    <br />
    <label for="enddate">End Date:</label>
    <input type="date" name="enddate" id="enddate" required placeholder="yyyy-mm-dd" />
    <span class="must">*</span>
    <button type="submit">
        Add
    </button>
</form>
</br>
</br>
</br>
<?php
    $mnum = $contractid = $startdate = $enddate = '';

    // Output the rest of the page and be done with this script
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $mnum = mysqli_real_escape_string($conn, $_POST['mnum']);
    $contractid = mysqli_real_escape_string($conn, $_POST['contractid']);
    $startdate = mysqli_real_escape_string($conn, $_POST['startdate']);
    $enddate = mysqli_real_escape_string($conn, $_POST['enddate']);
        
    $sql = "INSERT INTO Contracts (mnum, contractid, startdate, enddate) VALUES ('$mnum', '$contractid', '$startdate', '$enddate')";
    // Output the rest of the page and be done with this script
    if (!$conn->query($sql)) {
        echo "Insert error: " . mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    echo '<p class="success">Contract was succesfully added to the contracts table!</p>';
    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php'); 
?>
