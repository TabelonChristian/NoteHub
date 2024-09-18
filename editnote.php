<?php
session_start();

// Include the database connection file
include 'dbconnection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the form fields are set and not empty
if (isset($_POST['note_id'], $_POST['editFormTitle'], $_POST['editDescription'])) {
    // Sanitize input data
    $note_id = filter_var($_POST['note_id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['editFormTitle'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['editDescription'], FILTER_SANITIZE_STRING);

    // Connect to the database using the connectDB() function
    $pdo = connectDB();

    if ($pdo === null) {
        // Handle database connection error
        echo "Failed to connect to the database.";
        exit();
    }

    try {
        // Prepare an update statement to update the note in the database
        $stmt = $pdo->prepare("UPDATE notetable SET note_title = :title, note_desc = :description WHERE note_id = :note_id");

        // Bind parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':note_id', $note_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the dashboard after successful update
            header("Location: dashboard.php");
            exit();
        } else {
            // Handle update failure
            echo "Failed to update the note.";
            exit();
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    // Redirect to the dashboard if form fields are not set or empty
    header("Location: dashboard.php");
    exit();
}
?>