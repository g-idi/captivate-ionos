<?php

require_once "config.php";
require_once "session.php";


$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // validate if email is empty
    if (empty($email)) {
        $error .= '<p class="error">Please enter email.</p>';
    }

    // validate if password is empty
    if (empty($password)) {
        $error .= '<p class="error">Please enter your password.</p>';
    }

     if (empty($error)) {
        if($query = $db->prepare("SELECT * FROM users WHERE email = ?")) {
            $query->bind_param('s', $_POST['email']);
            $query->execute();
            $row = $query->get_result()->fetch_assoc();
            
            //if ($row) {
                
                if ($row && password_verify($_POST['password'], $row['password'])) {
                    //$_SESSION["userid"] = $row['id'];
                    //$_SESSION["user"] = $row;

                    //if (password_verify($password, $row['password'])) {
                //$_SESSION['user_id'] = $row['id'];

                    // Redirect the user to welcome page
                    header("location: welcome.php");
                  //exit;
                } 

                else { 
                    $error .= '<p class="error">Invalid Credentials.</p>';
                }
            } 

            else {
                $error .= '<p class="error">Invalid email.</p>';
            }
    
        
    }

    $query->close();
    // Close connection
    mysqli_close($db);
}
?>












<!DOCTYPE html>
<html lang="en">
    <head>
<!--         <meta charset="UTF-8">
 --><!--         <title>Login</title>
 -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login · CaptivateIQ</title>
        <link rel="shortcut icon" href="../app-cdn.captivateiq.com/bf21e93734aa5081b30caf2a6d46e3b78a4ab781/favicon.ico">
        <link rel="stylesheet" href="../app-cdn.captivateiq.com/bf21e93734aa5081b30caf2a6d46e3b78a4ab781/fonts/css/all.css">
        <link rel="stylesheet" href="../app-cdn.captivateiq.com/bf21e93734aa5081b30caf2a6d46e3b78a4ab781/font-awesome/5.11.2/css/all.min.css">
        
        <link type="text/css" href="../app-cdn.captivateiq.com/bf21e93734aa5081b30caf2a6d46e3b78a4ab781/build/main.964e5203d359f6698b75.css" rel="stylesheet" />
<!--         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
 -->    </head>
    <!-- <body> -->
        <!-- <div class="container">
            <div class="row">
                <div class="col-md-12"> -->

                    <body class="login-page">
        <div class="bg">
            <div class="bg-1"></div>
            <div class="bg-2"></div>
        </div>
        <img class="logo-img" src="../app-cdn.captivateiq.com/bf21e93734aa5081b30caf2a6d46e3b78a4ab781/images/logo-light.svg" />
        <div class="content-box">

                    <h2>Login</h2>
                    <p>Please fill in your email and password.</p>

                     <?php echo $error; ?>


                    <form action="" method="post">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required />
                        </div>    
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        </div>
                        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
                    </form>
                </div>
            </div>
        </div>    
    </body>
    </html>