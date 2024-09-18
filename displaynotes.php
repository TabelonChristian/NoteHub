<?php
// Include database connection
include 'dbconnection.php';

// Function to retrieve notes from the database and display them
function displayNotes($userId) {
    try {
        $conn = connectDB();

        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM notetable WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId);

        // Execute the statement
        $stmt->execute();

        // Fetch all rows as an associative array
        $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

        // Close the connection
        $conn = null;
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
}
?>