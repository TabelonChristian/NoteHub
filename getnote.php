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

// Check if the note_id is set and not empty
if (isset($_POST['note_id']) && !empty($_POST['note_id'])) {
    // Sanitize the note_id to prevent SQL injection
    $note_id = filter_var($_POST['note_id'], FILTER_SANITIZE_NUMBER_INT);

    // Retrieve user_id from the session
    $user_id = $_SESSION['user_id'];

    // Connect to the database using the connectDB() function
    $pdo = connectDB();

    if ($pdo === null) {
        // Handle database connection error
        echo json_encode(['error' => 'Failed to connect to the database.']);
        exit();
    }

    try {
        // Prepare a select statement to retrieve note data
        $stmt = $pdo->prepare("SELECT * FROM notetable WHERE note_id = :note_id AND user_id = :user_id");

        // Bind parameters
        $stmt->bindParam(':note_id', $note_id);
        $stmt->bindParam(':user_id', $user_id);

        // Execute the statement
        $stmt->execute();

        // Fetch note data
        $note = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($note) {
            // Return note data as JSON response
            echo json_encode(['note_title' => $note['note_title'], 'note_desc' => $note['note_desc']]);
        } else {
            // Note not found
            echo json_encode(['error' => 'Note not found.']);
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }
} else {
    // Note ID not provided
    echo json_encode(['error' => 'Note ID not provided.']);
}
?>