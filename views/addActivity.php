<?php
    // ==[DB CONNECTION DETAILS]==
    include('../util/db_connect.php');

    // ==[GLOBAL VARIABLES]==
    $errors = [
        'email' => '', 
        'activity' => '', 
        'tags' => '',
        'details' => ''
    ];
    $inputs = [
        'email' => '', 
        'activity' => '', 
        'tags' => '',
        'details' => ''
    ];

    // ==[EDIT GET CODE BLOCK]==
    if (isset($_GET['id'])) {
        // ==[LOCAL VARIABLES]==
        $activityId = $_GET['id'];

        // Get the data from the db using id
        // ==[QUERIES]==
        $getActivityWithId = "SELECT * FROM activities WHERE id = :activityId";

        // ==[EXECUTIONS]==
        try {
            // Conn to db.
            $conn = new PDO($dsn, $username, $password, $options);

            // Querying the db.
            $stmt = $conn->prepare($getActivityWithId);
            $stmt->execute(['activityId'=>$activityId]);

            // Fetch results.
            $result = $stmt->fetch();
            
            // Free up conn to server.
            $stmt->closeCursor();
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        // Pre-filling form with data from db.
        $inputs = [
            'email' => $result['email'], 
            'activity' => $result['activity'], 
            'tags' => $result['tags'],
            'details' => $result['details']
        ];
    }

    // ==[SAVING POST CODE BLOCK]==
    if (isset($_POST['submit'])) {
        // ==[INPUT VALIDATION]==
        // Email.
        if (empty($_POST['email'])) {
            $errors['email'] = "An email is required.";
        } else {
            $inputs['email'] = $_POST['email'];
            if(!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Valid email address required.';
            }
        }
        // Activity.
        if (empty($_POST['activity'])) {
            $errors['activity'] = "The activity name is required.";
        } else {
            $inputs['activity'] = $_POST['activity'];
            if(!preg_match('/^([a-zA-Z\s])(\s*[a-zA-Z\s]*)+$/', $inputs['activity'])) {
                $errors['activity'] = 'Valid activity name is required.';
            }
        }
        // Tags.
        if (empty($_POST['tags'])) {
            $errors['tags'] = "At least one tag required.";
        } else {
            $inputs['tags'] = $_POST['tags'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $inputs['tags'])) {
                $errors['tags'] = 'Tags need to be comma separated.';
            }
        }
        // Details.
        if (empty($_POST['details'])) {
            $errors['details'] = "Activity details required.";
        } else {
            $inputs['details'] = $_POST['details'];
        }
        
        // ==[SAVE AND REDIRECT]==
        // Redirect to index if no errors.
        if (array_filter($errors)) {
            echo "Error in form.";
        } else { 
            // ==[QUERIES]==
            // Query is for prepared statements.
            $insertNewActivityQuery = 
            "INSERT INTO activities (activity, tags, details, email)
            VALUES (:activity, :tags, :details, :email)";  
    
            // ==[EXECUTIONS]==
            try {
                // Db connection details using PDO.
                $conn = new PDO($dsn, $username, $password, $options);
    
                // Querying the database.
                $stmt = $conn->prepare($insertNewActivityQuery);
                $executedStmt = $stmt->execute([
                    'activity' => $inputs['activity'], 
                    'tags' => $inputs['tags'], 
                    'details' => $inputs['details'], 
                    'email' => $inputs['email']
                ]);
    
                // ==[DB QUERY SUCCESS CHECK]==
                if ($executedStmt) {
                    // Clear inputs after submit.
                    $inputs = [
                        'email' => '', 
                        'activity' => '', 
                        'tags' => '',
                        'details' => ''
                    ];
        
                    // Redirect to index.
                    header('Location: index.php');
                }
    
                // Free up conn to server.
                $stmt->closeCursor();
            } 
            // ==[ERR HANDLING]==
            catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
    };

    // Create a save block for edited Entries
    // Make sure the last edited column is updated
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
                                                    value="<?php echo htmlspecialchars($inputs['activity']) ?>">
                                            </div>
                                            <p class="help is-danger"><?php echo $errors['activity'] ?></p>
                                        </div>
                                
                                        <div class="field">
                                            <label for="tags">Tags</label>
                                            <div class="control">
                                                <input type="text" 
                                                    class="input 
                                                    <?php 
                                                        if ($errors['tags']) {
                                                            echo "is-danger";
                                                        }
                                                    ?>"
                                                    id="tags" 
                                                    name="tags"
                                                    value="<?php echo htmlspecialchars($inputs['tags']) ?>">
                                            </div>
                                            <p class="help is-danger"><?php echo $errors['tags'] ?></p>
                                        </div>
                                
                                        <div class="field">
                                            <label for="details">Details</label>
                                            <div class="control">
                                                <textarea name="details" 
                                                    class="textarea 
                                                    <?php 
                                                        if ($errors['tags']) {
                                                            echo "is-danger";
                                                        }
                                                    ?>"
                                                    id="details" 
                                                    maxlength="255"
                                                    cols="30" 
                                                    rows="10"><?php echo htmlspecialchars($inputs['details']) ?></textarea>
                                                <p class="help is-danger"><?php echo $errors['details'] ?></p>
                                            </div>
                                        </div>
        
                                        <div class="control">
                                            <input type="submit" name="submit" class="button is-primary" value="Submit">
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