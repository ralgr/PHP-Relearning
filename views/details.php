<?php 
    // ==[DB CONNECTION DETAILS]==
    include('../util/db_connect.php');

    // Check GET params.
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        // Redirect to index.
        header('Location: index.php');
    }

    // ==[QUERIES]==
    $getActivity = "SELECT * FROM activities WHERE id = :id ";

    // ==[EXECUTIONS]==
    try {
        // Db connection details using PDO.
        $conn = new PDO($dsn, $username, $password, $options);

        // Querying the db.
        $stmt = $conn->prepare($getActivity);
        $stmt->execute(['id' => $id]);
        
        // Query result.
        $result = $stmt->fetch();

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

    <h2>Details</h2>

<?php
    require('./templates/footer.php');
?>

</html>