<?php
    // ==[ACTIVITY CONTROLLER]==
    include('../controllers/activity.php');
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
                        <h1 class="title">
                            Add an Activity
                        </h1>
                    </div>
                </div>
                <div class="container">
                    <div class="columns">
                        <div class="column is-two-fifths">
                            <div class="card">
                                <h4 role="heading" class="card-header-title">Add an activity</h4>
                                <div class="card-content">
                                    <form action="<?php echo htmlentities($formAction) // ==[DC: form action]== ?>" method="POST">
                                        <div class="field">
                                            <label for="email">Email</label>
                                            <div class="control">
                                                <input type="email" 
                                                    class="input <?php 
                                                        // ==[DC: error class]==
                                                        if ($errors['email']) {
                                                            echo "is-danger";
                                                        }
                                                    ?>"
                                                    id="email" 
                                                    name="email"
                                                    value="<?php echo htmlspecialchars($inputs['email']) // ==[DC: email input value]== ?>">
                                            </div>
                                            <p class="help is-danger"><?php echo $errors['email'] // ==[DC: email error]== ?></p>
                                        </div>
                                
                                        <div class="field">
                                            <label for="activity">Activity</label>
                                            <div class="control">
                                                <input type="text" 
                                                    class="input <?php 
                                                        // ==[DC: error class]==
                                                        if ($errors['activity']) {
                                                            echo "is-danger";
                                                        }
                                                    ?>"
                                                    id="activity" 
                                                    name="activity"
                                                    value="<?php echo htmlspecialchars($inputs['activity']) // ==[DC: activity value]== ?>">
                                            </div>
                                            <p class="help is-danger"><?php echo $errors['activity'] // ==[DC: error msg]== ?></p>
                                        </div>
                                
                                        <div class="field">
                                            <label for="tags">Tags</label>
                                            <div class="control">
                                                <input type="text" 
                                                    class="input 
                                                    <?php 
                                                        // ==[DC: tags class]==
                                                        if ($errors['tags']) {
                                                            echo "is-danger";
                                                        }
                                                    ?>"
                                                    id="tags" 
                                                    name="tags"
                                                    value="<?php echo htmlspecialchars($inputs['tags']) // ==[DC: tags value]== ?>">
                                            </div>
                                            <p class="help is-danger"><?php echo $errors['tags'] // ==[DC: error msg]== ?></p>
                                        </div>
                                
                                        <div class="field">
                                            <label for="details">Details</label>
                                            <div class="control">
                                                <textarea name="details" 
                                                    class="textarea 
                                                    <?php 
                                                        // ==[DC: details class]==
                                                        if ($errors['tags']) {
                                                            echo "is-danger";
                                                        }
                                                    ?>"
                                                    id="details" 
                                                    maxlength="255"
                                                    cols="30" 
                                                    rows="10"><?php echo htmlspecialchars($inputs['details']) // ==[DC: details value]== ?></textarea>
                                                <p class="help is-danger"><?php echo $errors['details'] // ==[DC: error msg]== ?></p>
                                            </div>
                                        </div>
        
                                        <div class="control">
                                            <input type="submit" name="<?php echo htmlspecialchars($submitName); // ==[DC: submit name]== ?>" class="button is-primary" value="Submit">
                                        </div>
                                    </form>  
                                </div>
                            </div> 
                        </div>
                    </div>   
                </div>
            </section>
        </article>
    </main>

<?php
    require('./templates/footer.php');
?>

</html>