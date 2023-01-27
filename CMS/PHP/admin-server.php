<?php
// include composer autoloader
require '../vendor/autoload.php';
// Loading Varaibles from .env file.
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// initialize mongodb connection with url, username and password.
$db_client = new MongoDB\Client(
    'mongodb+srv://' . $_ENV['MONGODB_USER'] . ':' . $_ENV['MONGODB_PASSWORD'] . '@' . $_ENV['MONGODB_URL']
);
$DB_NAME = $_ENV['MONGODB_DATABASE'];
$db = $db_client->$DB_NAME; // 

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


