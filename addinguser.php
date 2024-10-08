<?php
include_once "dbconnection.php";

$conn = connectToDatabase();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

$firstnameErr = $lastnameErr = $dobErr = $emailErr = $usernameErr = $passwordErr = "";
$firstname = $lastname = $dob = $email = $username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstname"])) {
        $firstnameErr = "First Name is required";
    } else {
        $firstname = test_input($_POST["firstname"]);
    }

    if (empty($_POST["lastname"])) {
        $lastnameErr = "Last Name is required";
    } else {
        $lastname = test_input($_POST["lastname"]);
    }

    if (empty($_POST["dob"])) {
        $dobErr = "Date of Birth is required";
    } else {
        $dob = test_input($_POST["dob"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email address";
        }
    }

    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    $today = new DateTime();
    $birthdate = new DateTime($dob);
    $age = $birthdate->diff($today)->y;

    if ($firstname !== "" && $lastname !== "" && $dob !== "" && $email !== "" && $username !== "" && $password !== "") {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("SELECT * FROM usertable WHERE user_username = :username OR user_email = :email");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $usernameErr = "Username or email address already exists";
            } else {
                $stmt = $conn->prepare("INSERT INTO usertable (user_fname, user_lname, user_bdate, user_age, user_email, user_username, user_password) VALUES (:firstname, :lastname, :dob, :age, :email, :username, :password)");

                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':dob', $dob);
                $stmt->bindParam(':age', $age);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $hashed_password);

                $stmt->execute();

                header("Location: login.php");
                exit();
            }
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            echo "Error: Unable to process request";
        }
    }
}

if ($conn !== null) {
    $conn = null;
}
?>
