<?php

echo "
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='CSS/style.css'>
    <!-- Import Ajax Script. -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
    <script src='JS/AJAX/ajax.js'></script>
    <!-- Google Fonts. -->
    <link href='https://fonts.googleapis.com/css?family=Lato:100italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
    <!-- Google Icon Link -->
    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    <title>Admin Panel</title>
</head>
<!-- Main Container  -->

<body class='main-container'>
    <div class='header'>
        <!-- Header -->
        <img class='admin-logo' src='ASSETS/admin-logo.png' alt='admin-logo'>
        <h1 class='admin-login-h1'>Admin Panel</h1>
    </div>
    <div class='login-body'>
        <!-- Body - Login Section -->
        <div class='body-left-column'>
            <img class='admin-login-body-logo' src='ASSETS/gear.gif' alt='settings-logo'>
        </div>
        <div class='body-right-column'>
            <form class='admin-login-form '>
                <div>
                    <!-- Form Section -->
                    <label for='email'>Email Address</label><br>
                    <!-- Basic Validation -->
                    <input class='admin-login-form admin-login-form-field' type='email' id='email' name='email' required><br> <br>

                    <label for='password'>Password</label><br>
                    <input class='admin-login-form admin-login-form-field' type='password' id='password' name='password' required>
                </div>
                <br>
                <div>
                    <!-- Login Button -->
                    <button class='admin-field-form-btn' id='loginButton' type='button'>Login</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
";
