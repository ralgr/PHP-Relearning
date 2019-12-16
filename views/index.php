<?php
    //==[VARIABLES]==
    // Db and user details.
    $servername = "localhost";
    $dbname = "ralgrs_folly";
    $username = "ralgr";
    $password = "knightz78";
    
    // Connection details.
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    // Queries.
    $selectAllQuery = "SELECT activity, tags, id FROM activities ORDER BY created_at";

    try {
        // Db connection details using PDO.
        $conn = new PDO($dsn, $username, $password, $options);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //==[EXECUTIONS]==
        // Querying the database.
        $stmt = $conn->prepare($selectAllQuery);
        $stmt->execute();

        // Get result as an assoc array.
        $result = $stmt->fetchAll(); 

        // Echoing result on the DOM.
        echo(json_encode($result));
        
        // Free up conn to server.
        $stmt->closeCursor();
    } 
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">

<?php
    require('./templates/header.php');
?>

    <main>
        <article>
            <section class="hero is-primary">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        Activities
                    </h1>
                </div>
            </div>
            </section>
            <section>
                <div class="container">
                    <h4>Activities</h4>
                    <div class="row">
                        <?php foreach($result as $activity) { ?>

                            

                        <?php } ?>
                    </div>
                </div>
            </section>
        </article>
    </main>
<?php
    require('./templates/footer.php');
?>

</html>