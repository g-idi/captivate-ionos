




<?php

require_once "config.php";
require_once "session.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $fullname = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST["confirm_password"]);
     $password_hash = password_hash($password, PASSWORD_BCRYPT);

    if($query = $db->prepare("SELECT * FROM users WHERE email = ?")) {
        $error = '';
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $query->bind_param('s', $email);
    $query->execute();
    // Store the result so we can check if the account exists in the database.
    $query->store_result();
        if ($query->num_rows > 0) {
            $error .= '<p class="error">The email address is already registered!</p>';
        } else {
            // Validate password
            if (strlen($password ) < 6) {
                $error .= '<p class="error">Password must have atleast 6 characters.</p>';
            }

            // Validate confirm password
            if (empty($confirm_password)) {
                $error .= '<p class="error">Please enter confirm password.</p>';
            } else {
                if (empty($error) && ($password != $confirm_password)) {
                    $error .= '<p class="error">Password did not match.</p>';
                }
            }
            if (empty($error) ) {
                $insertQuery = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?);");
                $insertQuery->bind_param("sss", $fullname, $email, $password_hash);
                $result = $insertQuery->execute();
                if ($result) {
                    $error .= '<p class="success">Your registration was successful!</p>';
                } else {
                    $error .= '<p class="error">Something went wrong!</p>';
                }
            }
        }
    }
    $query->close();
    //$insertQuery->close();
    // Close DB connection
    mysqli_close($db);
}
?>













<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- <meta charset="UTF-8">
        <title>Sign Up</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
 -->    
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login · CaptivateIQ</title>
        <link rel="shortcut icon" href="app-cdn.captivateiq.com/bf21e93734aa5081b30caf2a6d46e3b78a4ab781/favicon.ico">
        <link rel="stylesheet" href="app-cdn.captivateiq.com/bf21e93734aa5081b30caf2a6d46e3b78a4ab781/fonts/css/all.css">
        <link rel="stylesheet" href="app-cdn.captivateiq.com/bf21e93734aa5081b30caf2a6d46e3b78a4ab781/font-awesome/5.11.2/css/all.min.css">
        
        <link type="text/css" href="app-cdn.captivateiq.com/bf21e93734aa5081b30caf2a6d46e3b78a4ab781/build/main.964e5203d359f6698b75.css" rel="stylesheet" />

</head>
<!--     <body>
 -->        <!-- <div class="container">
            <div class="row">
                <div class="col-md-12"> -->

                    <body class="login-page">
        <div class="bg">
            <div class="bg-1"></div>
            <div class="bg-2"></div>
        </div>
        <img class="logo-img" src="app-cdn.captivateiq.com/bf21e93734aa5081b30caf2a6d46e3b78a4ab781/images/logo-light.svg" />
        <div class="content-box">
                    <h2>Register</h2>
                    <p>Please fill this form to create an account.</p>

                    <?php echo $error; ?>

                    <form action="" method="post">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>    
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required />
                        </div>    
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        </div>
                        <p>Already have an account? <a href="login.php">Login here</a>.</p>
                    </form>
                </div>
            </div>
        </div>    
    </body>
    </html>