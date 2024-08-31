<?php

// Check if the 'id' field has been submitted via POST request
if (isset($_POST['id'])) {
    // Include the database connection script
    require '../db_conn.php';

    // Retrieve the 'id' value from the POST request
    $id = $_POST['id'];

    // Check if the 'id' field is empty
    if (empty($id)) {
        // If the ID is empty, return '0' to indicate failure
        echo 0;
    } else {
        // Prepare an SQL statement to delete the record from the 'todos' table where the ID matches
        $stmt = $conn->prepare("DELETE FROM todos WHERE id=?");

        // Execute the prepared statement with the ID as a parameter
        $res = $stmt->execute([$id]);

        // Check if the deletion was successful
        if ($res) {
            // If successful, return '1' to indicate success
            echo 1;
        } else {
            // If the deletion failed, return '0' to indicate failure
            echo 0;
        }
        // Close the database connection
        $conn = null;
        // Stop the script execution
        exit();
    }
} else {
    // If the 'id' field was not set, redirect to the homepage with an error message
    header("Location: ../index.php?mess=error");
}

