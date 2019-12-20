<?php 
    // ==[VARIABLES]==
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
?>