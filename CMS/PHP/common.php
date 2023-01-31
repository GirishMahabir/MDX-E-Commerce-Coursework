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
$db = $db_client->$DB_NAME;

function is_image($path)
{
    /*
    Function to check if a file is an image.
    Logic, if it's an image, it will be able to get the image size.
    */
    $a = getimagesize($path);
    $image_type = $a[2];

    if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
        return true;
    }
    return false;
}
