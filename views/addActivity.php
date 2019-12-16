<?php
    $errors = [
        'email' => '', 
        'activity' => '', 
        'tags' => ''
    ];

    $inputs = [
        'email' => '', 
        'activity' => '', 
        'tags' => ''
    ];

    if (isset($_POST['submit'])) {
        // Server-side email Validation
        if (empty($_POST['email'])) {
            $errors['email'] = "An email is required.";
        } else {
            $inputs['email'] = $_POST['email'];
            if(!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Valid email address required.';
            }
        }
    };

    if (isset($_POST['submit'])) {
        // Server-side activity Validation
        if (empty($_POST['activity'])) {
            $errors['activity'] = "The activity name is required.";
        } else {
            $inputs['activity'] = $_POST['activity'];
            if(!preg_match('/^[Aa-z-Z\s]+$/', $inputs['activity'])) {
                $errors['activity'] = 'Valid activity name is required.';
            }
        }
    };

    if (isset($_POST['submit'])) {
        // Server-side tags Validation
        if (empty($_POST['tags'])) {
            $errors['tags'] = "At least one tag required.";
        } else {
            $inputs['tags'] = $_POST['tags'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $inputs['tags'])) {
                $errors['tags'] = 'Tags need to be comma separated.';
            }
        }
    };

    if (array_filter($errors)) {
        echo "Error in form.";
    } else {
        if (isset($_POST['submit'])) {
            $inputs = [
                'email' => '', 
                'activity' => '', 
                'tags' => ''
            ];
    
            header('Location: index.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<?php
    require('./templates/header.php');
?>
    <main>
        <article>
            <section>
                <div class="container">
                    <div class="card">
                        <h4 role="heading" class="card-header-title">Add an activity</h4>
                        <div class="card-content">
                            <form action="addActivity.php" method="POST">
                                <div class="field">
                                    <label for="email">Email</label>
                                    <div class="control">
                                        <input type="email" 
                                            class="input <?php 
                                                if ($errors['email']) {
                                                    echo "is-danger";
                                                }
                                            ?>"
                                            id="email" 
                                            name="email"
                                            value="<?php echo htmlspecialchars($inputs['email']) ?>">
                                    </div>
                                    <p class="help is-danger"><?php echo $errors['email'] ?></p>
                                </div>
                        
                                <div class="field">
                                    <label for="activity">Activity</label>
                                    <div class="control">
                                        <input type="text" 
                                            class="input <?php 
                                                if ($errors['activity']) {
                                                    echo "is-danger";
                                                }
                                            ?>"
                                            id="activity" 
                                            name="activity"
                                            value="<?php echo $inputs['activity'] ?>">
                                    </div>
                                    <p class="help is-danger"><?php echo htmlspecialchars($errors['activity']) ?></p>
                                </div>
                        
                                <div class="field">
                                    <label for="tags">Tags</label>
                                    <div class="control">
                                        <input type="text" 
                                            class="input <?php 
                                                if ($errors['tags']) {
                                                    echo "is-danger";
                                                }
                                            ?>"
                                            id="tags" 
                                            name="tags"
                                            value="<?php echo $inputs['tags'] ?>">
                                    </div>
                                    <p class="help is-danger"><?php echo htmlspecialchars($errors['tags']) ?></p>
                                </div>
                        
                                <div class="field">
                                    <label for="details">Details</label>
                                    <div class="control">
                                        <textarea name="details" 
                                            class="textarea"
                                            id="details" 
                                            cols="30" 
                                            rows="10"></textarea>
                                    </div>
                                </div>

                                <div class="control">
                                    <input type="submit" name="submit" class="button is-primary" value="Submit">
                                </div>
                            </form>  
                        </div>
                    </div> 
                </div>
            </section>
        </article>
    </main>

    <div class="columns">
        <div class="column is-10 is-offset-1">
            <div class="columns">
                <div class="column is-6 is-offset-3">
                    
                </div>
            </div>
        </div>
    </div>


<?php
    require('./templates/footer.php');
?>

</html>