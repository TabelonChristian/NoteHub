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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are not empty
    if (!empty($_POST['formTitle']) && !empty($_POST['description'])) {
        // Retrieve form data
        $title = $_POST['formTitle'];
        $description = $_POST['description'];

        // Attempt to insert the note into the database
        try {
            // Establish database connection (if not already established)
            $pdo = connectDB();
            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }

            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO notetable (user_id, note_title, note_desc, note_date, note_status) VALUES (:user_id, :note_title, :note_desc, NOW(), 'Added')");

            // Bind parameters
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':note_title', $title);
            $stmt->bindParam(':note_desc', $description);

            // Execute the statement
            $stmt->execute();

            // Redirect to a success page or do something else
            header("Location: dashboard.php");
            exit();
        } catch(PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        } catch (Exception $e) {
            // Handle other exceptions
            echo "Error: " . $e->getMessage();
        }

    } else {
        // Handle empty form fields
        echo "Please fill out all fields.";
    }
}
?>