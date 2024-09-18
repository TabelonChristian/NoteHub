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

// Retrieve user_id from the session
$user_id = $_SESSION['user_id'];

// Check if note_id is set and not empty
if (isset($_POST['note_id']) && !empty($_POST['note_id'])) {
    // Sanitize the note_id to prevent SQL injection
    $note_id = filter_var($_POST['note_id'], FILTER_SANITIZE_NUMBER_INT);

    // Connect to the database using the connectDB() function
    $pdo = connectDB();

    if ($pdo === null) {
        // Handle database connection error
        echo "Failed to connect to the database.";
        exit();
    }

    try {
        // Prepare a delete statement
        $stmt = $pdo->prepare("DELETE FROM notetable WHERE note_id = :note_id AND user_id = :user_id");

        // Bind parameters
        $stmt->bindParam(':note_id', $note_id);
        $stmt->bindParam(':user_id', $user_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect back to the dashboard after successful deletion
            header("Location: dashboard.php");
            exit();
        } else {
            // Handle deletion failure
            echo "Failed to delete the note.";
            exit();
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    // Redirect to the dashboard if note_id is not set or empty
    header("Location: dashboard.php");
    exit();
}
?>