<?php
// Include database connection
include 'dbconnection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Retrieve user_id from the session
$user_id = $_SESSION['user_id'];

// Function to retrieve notes from the database and display them
function displayNotes($userId) {
    try {
        $pdo = connectToDatabase();

        // Prepare the SQL statement
        $stmt = $pdo->prepare("SELECT * FROM notetable WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId);

        // Execute the statement
        $stmt->execute();

        // Fetch all rows as an associative array
        $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if there are any notes to display
        if (count($notes) == 0) {
            echo '<p>No notes to display.</p>';
        } else {
            // Loop through the notes and display them
            foreach ($notes as $note) {
                echo '<div class="listnote">';
                echo '<div class="title">';
                echo '<p>' . $note['note_title'] . '</p>';
                echo '</div>';
                echo '<div class="description">';
                echo '<p>' . $note['note_desc'] . '</p>';
                echo '</div>';
                echo '<div class="stat">';
                echo '<div class="date">' . $note['note_date'] . '</div>';
                // Add other elements like favorite, edit, delete buttons if needed
                echo '</div>';
                echo '</div>';
            }
        }

        // Close the connection
        $pdo = null;
    } catch (PDOException $e) {
        // Handle any errors
        error_log("Error: " . $e->getMessage());
        echo "Error: Unable to process request";
    }
}

// Call the function to display the notes
displayNotes($user_id);
?>
