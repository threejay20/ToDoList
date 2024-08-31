<?php

// Check if the 'id' field has been submitted via POST request
if (isset($_POST['id'])) {
    // Include the database connection script
    require '../db_conn.php';

    // Retrieve the 'id' value from the POST request
    $id = $_POST['id'];

    // Check if the 'id' field is empty
    if (empty($id)) {
        // If the ID is empty, return an 'error' message
        echo 'error';
    } else {
        // Prepare an SQL statement to select the ID and checked status from the 'todos' table
        $todos = $conn->prepare("SELECT id, checked FROM todos WHERE id=?");
        
        // Execute the prepared statement with the ID as a parameter
        $todos->execute([$id]);

        // Fetch the result as an associative array
        $todos = $todos->fetch();
        
        // Get the ID and checked status from the fetched result
        $uId = $todos['id'];
        $checked = $todos['checked'];

        // Toggle the checked status (if checked, uncheck; if unchecked, check)
        $uChecked = $checked ? 0 : 1;

        // Update the checked status in the database for the specific ID
        $res = $conn->query("UPDATE todos SET checked=$uChecked WHERE id=$uId");

        // Check if the update was successful
        if ($res) {
            // If successful, return the original checked status
            echo $checked;
        } else {
            // If the update failed, return an 'error' message
            echo "error";
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

