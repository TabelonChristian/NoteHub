<?php
function connectToDatabase() {
    $servername = getenv ('DB_HOST') ?: 'localhost';
    $username = getenv  ('DB_USERNAME') ?: 'root';
    $password = getenv('DB_PASSWORD')?: '';
    $database = getenv('DB_DATABASE') ?: 'note_db';
    $port = getenv('DB_PORT')?: '3306';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database;port=$port", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die ("Connection Failed: " . $e->getMessage());
    }
}

$conn = connectToDatabase();
?>
