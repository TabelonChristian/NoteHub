<?php
include_once 'dbconnection.php';

$username = $password = "";
$usernameErr = $passwordErr = "";
$submitted = false; // Flag to track if form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitted = true; // Set submitted flag to true

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

    if ($username !== "" && $password !== "") {
        header("Location: dashboard.php");
        exit();
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Css/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <style>

        
        .error1{
            color:red;
            position: absolute;
            bottom:420px;
            right: 455px;px;
        }
        .error2{
            color:red;
            position: absolute;
            bottom:335px;
            right: 455px;px;
        }



        
    </style>



</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="Logo">
                <a href="Landingpage.php"><i class='bx bx-arrow-back'></i></a>
                <h2>Login to Note<span class="hub">hub</span></h2>
            </div>
            <form class="forms" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="username" placeholder="Username" class="<?php echo !empty($usernameErr) && $submitted ? 'error-field' : ''; ?>">
                <?php if (!empty($usernameErr) && $submitted) { ?>
                    <span class="error1"><?php echo $usernameErr;?></span>
                <?php } ?>
                <br>
                <input type="password" name="password" placeholder="Password" class="<?php echo !empty($passwordErr) && $submitted ? 'error-field' : ''; ?>">
                <?php if (!empty($passwordErr) && $submitted) { ?>
                    <span class="error2"><?php echo $passwordErr;?></span>
                <?php } ?>
                <br>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

  <script>
        // Function to hide error messages after 2 seconds
        setTimeout(function() {
            document.querySelectorAll('.error1, .error2').forEach(function(element) {
                element.style.display = 'none';
            });
        }, 2000);
    </script>

</body>
</html>
