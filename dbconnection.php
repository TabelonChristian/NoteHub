<?php
function connectDB() {
    $host = "localhost";
    $dbname = "notes";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        error_log("Connection failed: " . $e->getMessage());
        return null;
    }
}
?>
