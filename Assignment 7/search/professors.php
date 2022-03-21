<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $where = "U.uid = P.uid";
    $fields = [
        'firstname',
        'lastname',
        'email',
    ];

    foreach ($fields as $field) {
        if (isset($_GET[$field])) {
            $value = mysqli_real_escape_string($conn, $_GET[$field]);
            $where .= " AND $field LIKE '%{$value}%'";
        }
    }

    $sql = "
        SELECT P.profid, U.firstname, U.lastname, U.email, P.profid, P.faculty
        FROM Users U, Professors P
        WHERE $where
        ORDER BY U.uid
    ";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

?>
    <h2>Search for Professors</h2>
    <h3>
        Filter
    </h3>
    <form method='GET' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="firstname">Firstname:</label>
        <input type="text" name="firstname" id="firstname" />
        <br/>

        <label for="lastname">Lastname:</label>
        <input type="text" name="lastname" id="lastname" />
        <br/>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" />
        <br/>
        <br/>

        <button type="submit">
            Filter
        </button>
    </form>
    <br />
    <br />
    <?php
        if ($result->num_rows > 0) { 
    ?>
    <table>
        <thead>
            <tr style='text-align: center;'>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Professor ID</th>
                <th>Faculty</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td>
                    <a href="<?=ROOT?>view/professor.php?profid=<?=$row['profid']?>">
                        <?=$row['firstname']?>
                    </a> 
                </td>
                <td><?=$row['lastname']?></td>
                <td><?=$row['email']?></td>
                <td><?=$row['profid']?></td>
                <td><?=$row['faculty']?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php
    } else {
?>
    <h2>No Entries</h2>
<?php
    }

    mysqli_close($conn);
    include_once(__DIR__ . '/../app/end.php');
?>
