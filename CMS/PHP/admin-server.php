<?php

include 'common.php';

$db_users = $db->users; // collection

// get data from post request and fetch it into variables.
$email = $_POST["email"];
$password = $_POST["password"];

// use try catch to catch error if email is not found.
try {
    // check if user exists
    $user = $db_users->findOne(['email' => $email]);
    $role = $user['role']; // get role from db
} catch (Exception $e) {
    echo json_encode(array(
        "status" => "error",
        "message" => "User does not exist."
    ));
    exit();
}

$role = $user['role']; // get role from db

// If user exists:
if ($user and $role == 'admin') {
    // get password from db:
    $db_password = $user['password'];
    // check if password is correct:
    if ($password == $db_password) {
        // return success
        echo json_encode(array(
            "status" => "success",
            "message" => "User exists and password is correct."
        ));
        // log authentication success
        error_log("$email logged in to admin panel.", 0);
        // set session cookie for logged in that expires in 15 minutes.
        setcookie("admin", $email, time() + (90), "/"); // 90 * 30 = 15 minutes.
    } else {
        echo json_encode(array(
            "status" => "error",
            "message" => "User exists but password is incorrect."
        ));
    }
} else {
    error_log("$email tried to login to admin panel.");
    echo json_encode(array(
        "status" => "error",
        "message" => "User does not exist."
    ));
};
