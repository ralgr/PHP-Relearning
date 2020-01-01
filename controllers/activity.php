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
    $activityId = 
        isset($_GET['id']) && $_GET['id'] != null
        ? $_GET['id']
        : "";
    $submitName = "submit";
    $formAction = "addActivity.php";
    if (isset($_GET['id']) 
        && $_GET['id'] != null 
        && isset($_GET['editMode']) 
        && $_GET['editMode'] == true 
        || isset($_GET['id'])
        && $_GET['id'] != null 
        && isset($_GET['submit']) 
        && $_GET['submit'] == true) 
    {
        $submitName = "editSubmit";
        $formAction = "addActivity.php?id={$activityId}&submit=true";
    }

    // ==[EDIT GET CODE BLOCK]==
    if (isset($_GET['id']) 
        && $_GET['id'] != null 
        && isset($_GET['editMode']) 
        && $_GET['editMode'] == true) 
    {
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

    // Update query
    // ==[EDITING POST CODE BLOCK]==
    if (isset($_POST['editSubmit'])) {
        // ==[INPUT VALIDATION]==
        include('../util/input_validation.php');
        
        // Update activity using id.
        // ==[QUERIES]==
        $updateActivityWithId = 
            "UPDATE activities
            SET activity = :activity, 
                tags = :tags, 
                details = :details,
                last_modified = CURRENT_TIMESTAMP
            WHERE id = :id";

        // ==[UPDATE AND REDIRECT]==
        // Redirect to index if no errors.
        if (array_filter($errors)) {
            echo "Error in form.";
        } else {
            // ==[EXECUTIONS]==
            try {
                $conn = new PDO($dsn, $username, $password, $options);
    
                $stmt = $conn->prepare($updateActivityWithId);
                $executedStmt = $stmt->execute([
                    'activity' => $inputs['activity'], 
                    'tags' => $inputs['tags'], 
                    'details' => $inputs['details'],
                    'id' => $activityId
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
            catch (PDOException $th) {
                throw $th;
            }
        } 
    }

    // ==[SAVING POST CODE BLOCK]==
    if (isset($_POST['submit'])) {
        echo "SAVING ACTIVATED";
        // ==[INPUT VALIDATION]==
        include('../util/input_validation.php');
        
        // ==[QUERIES]==
        // Query is for prepared statements.
        $insertNewActivityQuery = 
            "INSERT INTO activities (activity, tags, details, email)
            VALUES (:activity, :tags, :details, :email)"; 

        // ==[SAVE AND REDIRECT]==
        // Redirect to index if no errors.
        if (array_filter($errors)) {
            echo "Error in form.";
        } else { 
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
    } 
?>