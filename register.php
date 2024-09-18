<?php 
include_once 'dbconnection.php';

function test_input($data) {
    $data = trim($data);       
    $data = stripslashes($data); 
    $data = htmlspecialchars($data); 
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitted = true; // Set submitted flag to true

    // Validate first name
    if (empty($_POST["firstname"])) {
        $firstnameErr = "First Name is required";
    } else {
        $firstname = test_input($_POST["firstname"]);
    }

    // Validate last name
    if (empty($_POST["lastname"])) {
        $lastnameErr = "Last Name is required";
    } else {
        $lastname = test_input($_POST["lastname"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // You can add additional validation for email format if needed
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } elseif (strlen($_POST["password"]) < 6) {
        $passwordErr = "Password must be at least 6 characters long";
    } elseif (!preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $_POST["password"])) {
        $passwordErr = "Password must contain at least one special character";
    } else {
        $password = test_input($_POST["password"]);
    }
   
    if (empty($firstnameErr) && empty($lastnameErr) && empty($emailErr) && empty($passwordErr)) {
        // Your database insertion code goes here
        header("Location: dashboard.php");
        exit();
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="Css/register.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Style for error messages */
        .error1 {
            color: red;
            font-size: 0.8em;
            display: none;
            position: absolute;
            top:289px;
            left:600px;
        }
        .error2 {
            color: red;
            font-size: 0.8em;
            display: none;
            position: absolute;
            top:369px;
            left:600px;
        
        }
        .error3 {
            color: red;
            font-size: 0.8em;
            display: none;
            position: absolute;
            top:920px;
        }
        .error4 {
            color: red;
            font-size: 0.8em;
            display: none;
            position: absolute;
            top: 485px;
            left:590px;
        }
        .error5 {
            color: red;
            font-size: 0.8em;
            display: none;
            position: absolute;
            top: 485px;
            right:510px;
        }
        .error6 {
            color: red;
            font-size: 0.8em;
            display: none;
            position: absolute;
            top: 590px;
            right:555px;
        }
    </style>
</head>

<body>
    <div class="register">
        <div class="Logo">
            <a href="Landingpage.php"><i class='bx bx-arrow-back'></i></a>
            <h2>Register to Note<span class="hub">hub</span></h2>
        </div>
        <div class="form-register">
            <form id="registrationForm" action="register.php" method="post">
                <div class="form">
                    <div class="col1">
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" placeholder="First Name" title="First Name is required" pattern=".{1,}" required>
                        <div class="error1" id="firstnameErr"></div> <!-- Container for error message -->
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" placeholder="Last Name" title="Last Name is required" pattern=".{1,}" required>
                        <div class="error2" id="lastnameErr"></div> <!-- Container for error message -->
                    </div>
                    <div class="col2">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" placeholder="Date of Birth" onchange="calculateAge()">
                        <div class="error3" id="dobErr"></div> <!-- Container for error message -->
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" placeholder="Age" readonly>
                    </div>

                    <div class="col5">
                    <div>
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Username" title="Username is required" pattern=".{1,}" required>
                        <div class="error4" id="usernameErr"></div> <!-- Container for error message -->
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password" title="Password is required and must be at least 6 characters long and contain a special character" pattern=".{6,}" required>
                        <div class="error5" id="passwordErr"></div> <!-- Container for error message -->
                    </div>
                </div>


                    <div class="col4">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email" title="Email is required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                        <div class="error6" id="emailErr"></div> <!-- Container for error message -->

                    </div>
                    <button class="submitreg" type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>
    <script src="Jsscript/register.js">


    </script>
</body>

</html>
