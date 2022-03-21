<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect-readonly.php');
    if ($conn === false) {
        echo '<p class="error">Error connecting to the SQL Database!</p>';
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

    $where = "TRUE";
    $fields = [
        'shortname',
        'longname',
    ];

    foreach ($fields as $field) {
        if (isset($_GET[$field])) {
            $value = mysqli_real_escape_string($conn, $_GET[$field]);
            $where .= " AND $field LIKE '%{$value}%'";
        }
    }

    $sql = "
        SELECT C.shortname, C.longname, C.courseid
        FROM Courses C
        WHERE $where
        ORDER BY C.courseid
    ";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }

?>
    <h2>Search for Courses</h2>
    <h3>
        Filter
    </h3>
    <form method='GET' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="shortname">Shortname:</label>
        <input type="text" name="shortname" id="shortname" />
        <br/>

        <label for="longname">Longname:</label>
        <input type="text" name="longname" id="longname" />
        <br/>
        <br/>

        <button type="submit">
            Filter
        </button>
    </form>

    <!--The autocomplete JS Script-->
    <script>
    var tagslongname = [

    <?php
        $autocompletesql = "SELECT C.longname FROM Courses C";

        $autocompleteresult = $conn->query($sql);
        if (!$autocompleteresult) {
            echo mysqli_error($conn);
            mysqli_close($conn);
            include_once(__DIR__ . '/../app/end.php');
            exit();
        }

        if($autocompleteresult->num_rows > 0) {
            while($autocompleterow = $autocompleteresult->fetch_assoc()) {
            ?>
            "<?=$autocompleterow[longname]?>" ,
            <?php
            }
        }

    ?>
    
    ];
    $( "#longname" ).autocomplete({
      source: function( request, response ) {
                    var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
                              response( $.grep( tagslongname, function( item ){
                                                return matcher.test( item );
                                                          }) );
                          }
    });
    </script>

    <br />
    <br />
    <?php
        if ($result->num_rows > 0) { 
    ?>
    <table>
        <thead>
            <tr style='text-align: center;'>
                <th>Short Name</th>
                <th>Long Name</th>
                <th>Course ID</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td>
                    <a href="<?=ROOT?>view/course.php?courseid=<?=$row['courseid']?>">
                        <?=$row['shortname']?>
                    </a> 
                </td>
                <td><?=$row['longname']?></td>
                <td><?=$row['courseid']?></td>
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
