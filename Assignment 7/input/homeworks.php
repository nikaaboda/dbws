<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }
?>
<h2>Insert a new Homework</h2>
<a href="<?=ROOT?>reference/homeworks.php" class="reference">Reference</a>
<form method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="title">Title:</label>
    <input type="text" name="title" required></input><span class="must">*</span>
    </br>
    <label for="description">Description:</label>
    <input type="text" name="description" required></input><span class="must">*</span>
    </br>
    <label for="deadline">Deadline:</label>
    <input type="date" name="deadline" required></input><span class="must">*</span>

    <button type="submit">
        Add
    </button>
</form>
</br>
</br>
</br>
<?php
    $title = $description = $deadline = '';

    // Output the rest of the page and be done with this script
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $deadline = mysqli_real_escape_string($conn, $_POST['deadline']);
        
    $sql = "INSERT INTO Tasks (title, description) VALUES ('$title', '$description')";
    // Output the rest of the page and be done with this script
    if (!$conn->query($sql)) {
        echo "Insert error: " . mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    echo '<p class="success">Task was succesfully added to the tasks table!</p>';

    $tid = $conn->insert_id;
    $sql = "INSERT INTO Homeworks (tid, deadline) VALUES ('$tid', '$deadline')";
    if(!$conn->query($sql)){
        echo 'Insert error: ' . mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    echo '<p class="success">Homework was succesfully added to the homeworks table!</p>';
    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php'); 
?>
