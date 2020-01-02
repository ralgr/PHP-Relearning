<?php
    // ==[INDEX CONTROLLER]==
   require('../controllers/indexCtrl.php'); 
?>

<!DOCTYPE html>
<html lang="en">

<?php
    require('./templates/header.php');
?>

    <main>
        <article>
            <section class="section">
                <div class="hero-body">
                    <div class="container">
                        <h1 class="title">Activities</h1>
                    </div>
                </div>
                <div class="container">
                    <div class="columns is-multiline">

                        <?php 
                            foreach($result as $activity): 
                            // Replacing ','-serparated tags into an array of indivual tags.
                            $activity['tags'] = explode(', ', $activity['tags']);
                        ?>
                        <div class="column is-4">
                            <div class="card">
                                <!-- ==[CARD HEADER]== -->
                                <header class="card-header">
                                    <p class="card-header-title">
                                        <?php echo htmlspecialchars($activity['activity']) ?>
                                    </p>
                                    <a href="#" class="card-header-icon" aria-label="more options">
                                    <span class="icon">
                                        <form action="index.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($activity['id']) ?>">
                                            <button type="submit" class="button is-danger is-inverted">
                                                <i class="fas fa-times" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </span>
                                    </a>
                                </header>
                                <!-- ==[CARD CONTENT]== -->
                                <div class="card-content">
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
                                <!-- ==[CARD FOOTER]== -->
                                <footer class="card-footer">
                                    <a href="details.php?id=<?php echo htmlspecialchars($activity['id']) ?>" class="card-footer-item">Details</a>
                                    <a href="addActivity.php?id=<?php echo htmlspecialchars($activity['id']) ?>&editMode=true" class="card-footer-item">Edit</a>
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