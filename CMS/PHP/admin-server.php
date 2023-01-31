<?php

include 'common.php';

$db_users = $db->users; // collection

// get data from post request and fetch it into variables.
$email = $_POST["email"];
$password = $_POST["password"];

// check if user exists
$user = $db_users->findOne(['email' => $email]);
$role = $user['role']; // get role from db
// If user exists:
if ($user and $role == 'admin') {
    // get password from db:
    $db_password = $user['password'];
    // check if password is correct:
    if ($password == $db_password) {
        echo "User exists and password is correct";
        // Redirect to admin panel:
        header("Location: ./admin-panel.php", true, 301);
    } else {
        echo "User exists but password is incorrect";
    }
} else {
    echo "User does not exist";
    error_log("$email tried to login to admin panel.");
};
