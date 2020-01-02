<?php
    // ==[DB CONNECTION DETAILS]==
    include('../util/db_connect.php');
    
    // ==[QUERIES]==
    $selectAllQuery = "SELECT * FROM activities ORDER BY created_at";
    $deleteActivityQuery = "DELETE FROM activities WHERE id = :id";

    if ( isset($_POST['id']) ) 
    {
        // ==[VARIABLES]==
        $activityId = $_POST['id'];

        // ==[EXECUTIONS]==
        try {
            // new PDO.
            include('../util/new_pdo.php');
        
            // Querying the database.
            $stmt = $conn->prepare($deleteActivityQuery);
            $executedStmt = $stmt->execute(['id' => $activityId]);
        
            // ==[DB QUERY SUCCESS CHECK]==
            if ($executedStmt) {
                // Free up conn to server.
                $stmt->closeCursor();

                // Redirect to index.
                header('Location: index.php');
            }
        
        } 
        // ==[ERR HANDLING]==
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // ==[EXECUTIONS]==
    try {
        // // new PDO.
        include('../util/new_pdo.php');
    
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