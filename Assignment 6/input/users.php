<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }
?>
<h2>Insert a new User</h2>
<a href="<?=ROOT?>reference/professors.php" class="reference">Reference</a>
<form method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="firstname">Firstname:</label>
    <input type="text" name="firstname" id="firstname" required/><span class="must">*</span>
    <br/>

    <label for="lastname">Lastname:</label>
    <input type="text" name="lastname" id="lastname" required/><span class="must">*</span>
    <br/>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required/><span class="must">*</span>

    <button type="submit">
        Add
    </button>
</form>
</br>
</br>
</br>
<?php
    $firstname = $lastname = $email = '';

    // Output the rest of the page and be done with this script
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
        
    $sql = "INSERT INTO Users (firstname, lastname, email) VALUES ('$firstname', '$lastname', '$email')";
    if (!$conn->query($sql)) {
        echo "Insert error: " . mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    echo '<p class="success">User was succesfully added to the Users table!</p>';
    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php'); 
?>
