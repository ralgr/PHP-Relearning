<?php
    // ==[DB CONNECTION DETAILS]==
    include('../util/db_connect.php');

    // ==[QUERIES]==
    $selectAllQuery = "SELECT * FROM activities ORDER BY created_at";

    // ==[EXECUTIONS]==
    try {
        // Db connection details using PDO.
        $conn = new PDO($dsn, $username, $password, $options);

        // Querying the database.
        $stmt = $conn->prepare($selectAllQuery);
        $stmt->execute();

        // Get result as an assoc array.
        $result = $stmt->fetchAll();

        // Free up conn to server.
        $stmt->closeCursor();
    } 
    // ==[ERR HANDLING]==
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
            <section class="hero">
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
                    <div class="columns is-multiline">
                        <?php 
                            foreach($result as $activity): 
                            // Replacing ','-serparated tags into an array of indivual tags.
                            $activity['tags'] = explode(', ', $activity['tags']);
                        ?>
    
                            <div class="column is-4">
                                <div class="card">
                                    <div class="card-content">
                                        <p class="title">
                                            <?php echo htmlspecialchars($activity['activity']) ?> 
                                        </p>
                                        <div class="content">
                                            <p class="card__details">
                                                <?php echo htmlspecialchars($activity['details']) ?>
                                            </p>

                                            <p class="card__tags">
                                                <?php 
                                                    // Loop through each tags and output them.
                                                    foreach($activity['tags'] as $tag):  
                                                ?>
                                                    <a href="#" class="chips"><?php echo htmlspecialchars("{$tag}") ?></a>
                                                <?php endforeach; ?>
                                            </p>

                                            <p class="card__last-modified">
                                                <time datetime="<?php echo htmlspecialchars($activity['last_modified']) ?>">
                                                    <?php echo htmlspecialchars($activity['last_modified']) ?>
                                                </time>
                                            </p>
                                        </div>
                                    </div>
                                    <footer class="card-footer">
                                        <a href="#" class="card-footer-item">Edit</a>
                                        <a href="#" class="card-footer-item">Delete</a>
                                    </footer>
                                </div>
                            </div>
    
                            <?php endforeach; ?>
                    </div>
                </div>
            </section>
        </article>
    </main>
<?php
    require('./templates/footer.php');
?>

</html>