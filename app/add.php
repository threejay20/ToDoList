<?php

// Check if the 'title' field has been submitted via POST request
if (isset($_POST['title'])) {
    // Include the database connection script
    require '../db_conn.php';

    // Retrieve the 'title' value from the POST request
    $title = $_POST['title'];

    // Check if the 'title' field is empty
    if (empty($title)) {
        // If the title is empty, redirect to the homepage with an error message
        header("Location: ../index.php?mess=error");
    } else {
        // Prepare an SQL statement to insert the title into the 'todos' table
        $stmt = $conn->prepare("INSERT INTO todos(title) VALUE(?)");

        // Execute the prepared statement with the title as a parameter
        $res = $stmt->execute([$title]);

        // Check if the insertion was successful
        if ($res) {
            // If successful, redirect to the homepage with a success message
            header("Location: ../index.php?mess=success");
        } else {
            // If the insertion failed, redirect to the homepage without any message
            header("Location: ../index.php");
        }
        // Close the database connection
        $conn = null;
        // Stop the script execution
        exit();
    }
} else {
    // If the 'title' field was not set, redirect to the homepage with an error message
    header("Location: ../index.php?mess=error");
}

