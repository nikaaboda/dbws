<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }
?>
<h2>Insert a new Task</h2>
<form method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="title">Title:</label>
    <input type="text" name="title" required/><span class="must">*</span>
    </br>
    <label for="description">Description:</label>
    <input type="text" name="description" required/><span class="must">*</span>
    </br>

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
    $title = $description = '';

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

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
        
    $sql = "INSERT INTO Tasks (title, description) VALUES ('$title', '$description')";
    // Output the rest of the page and be done with this script
    if (!$conn->query($sql)) {
        echo "Insert error: " . mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    echo '<p class="success">Task was succesfully added to the tasks table!</p>';
    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php'); 
?>
