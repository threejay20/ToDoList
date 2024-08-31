<?php

// Define the database server name (usually 'localhost' for a local server)
$sName = "localhost";

// Define the database username (default is 'root' for local installations)
$uName = "root";

// Define the database password (empty in this case, but should be set in production)
$pass = "";

// Define the name of the database to connect to
$db_name = "to-do-list";

try {
    // Create a new PDO (PHP Data Object) instance to connect to the database
    // The DSN (Data Source Name) includes the database type (MySQL), host (localhost), and database name (to-do-list)
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    
    // Set an attribute on the PDO object to handle errors as exceptions
    // This makes it easier to catch and handle errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // If there is an error connecting to the database, catch the exception
    // Display an error message with the details of the exception
    echo "Connection failed: " . $e->getMessage();
}
?>
