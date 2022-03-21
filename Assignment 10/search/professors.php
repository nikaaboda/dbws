<?php
    include_once(__DIR__ . '/../app/start.php');
    
    $conn = require(__DIR__ . '/../app/connect-readonly.php');
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

    $autocompletesql = "SELECT UNIQUE U.firstname, U.lastname, U.email FROM Users U, Professors P WHERE U.uid = P.uid"; 

    $autocompleteresult = $conn->query($autocompletesql);
    if (!$autocompleteresult) {
        echo mysqli_error($conn);
        mysqli_close($conn);
        include_once(__DIR__ . '/../app/end.php');
        exit();
    }
?>
    <head>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>
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

    <!--The autocomplete JS Script-->
    <script>
        var firstnametags = [];
        var lastnametags = [];
        var emailtags = [];
        <?php
            if($autocompleteresult->num_rows > 0) {
                while($autocompleterow = $autocompleteresult->fetch_assoc()) {
                ?>
                firstnametags.push("<?=$autocompleterow[firstname]?>");
                lastnametags.push("<?=$autocompleterow[lastname]?>");
                emailtags.push("<?=$autocompleterow[email]?>");
                <?php
                }
            }

        ?>

        $( "#firstname" ).autocomplete({
          source: function( request, response ) {
                        var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
                                  response( $.grep( firstnametags, function( item ){
                                                    return matcher.test( item );
                                                              }));
          },
          search: "",
          minLength: 0
        }).focus(function() {
            $(this).autocomplete("search", "");
        });

        $( "#lastname" ).autocomplete({
          source: function( request, response ) {
                        var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
                                  response( $.grep( lastnametags, function( item ){
                                                    return matcher.test( item );
                                                              }) );
          },
          search: "",
          minLength: 0
        }).focus(function() {
            $(this).autocomplete("search", "");
        });
        
        $( "#email" ).autocomplete({
          source: function( request, response ) {
                        var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
                                  response( $.grep(emailtags, function( item ){
                                                    return matcher.test( item );
                                                              }) );
          },
          search: "",
          minLength: 0
        }).focus(function() {
            $(this).autocomplete("search", "");
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
