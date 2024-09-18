<?php
session_start();

include 'dbconnection.php';

try {
    $conn = connectDB();

    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT user_id, user_fname, user_lname, user_password FROM usertable WHERE user_username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Verify the password
        if (password_verify($password, $result['user_password'])) {
            $_SESSION["user_id"] = $result["user_id"];
            $_SESSION["firstname"] = $result["user_fname"];
            $_SESSION["lastname"] = $result["user_lname"];
            
            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Password is incorrect, redirect back to login page
            header("Location: login.php?error=invalid_password");
            exit();
        }
    } else {
        // User not found, redirect back to login page
        header("Location: login.php?error=user_not_found");
        exit();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>