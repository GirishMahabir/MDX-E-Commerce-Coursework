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

$db_products = $db->products; // collection

// get data from post request and fetch it into variables.
$pid = $_POST["pid"];
$product_name = $_POST["product_name"];
$description = $_POST["description"];
$price = $_POST["price"];
$quantity = $_POST["quantity"];

// image upload code
$target_dir = "../ASSETS/Products/";
$banner = $_FILES["image"]["name"];
$FILE_SIZE_LIMIT = $_ENV['FILE_SIZE_LIMIT'];

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

// Check if image file is a actual image or fake image.
$bannerPath = $target_dir . $pid . "-" . basename($banner);
// Download the image from the url and save it to the server

if (move_uploaded_file($_FILES["image"]["tmp_name"], $bannerPath)) {
    // check if the file is an image:
    if (is_image($bannerPath)) {
        error_log("The file " . basename($banner) . " has been uploaded.", 0);
    } else {
        error_log("The file $bannerPath is not an image.");
        // remove the file:
        $delete_status = unlink($bannerPath);
        if ($delete_status) {
            error_log("The file $bannerPath has been deleted.");
        } else {
            error_log("The file $bannerPath could not be deleted.");
        }
    }
} else {
    // echo '<script>alert("Sorry, there was an error uploading your file. Please try again.")</script>';
}

// insert data into mongodb
// Check if pid already exists
$check = $db_products->findOne(['pid' => $pid]);
if ($check) {
    echo '<script>alert("Product already exists, Please update the product.")</script>';
} else {
    // insert data into mongodb (image converted to binary)
    $binaryData = file_get_contents($bannerPath);
    $insertOneResult = $db_products->insertOne([
        'productId' => $pid,
        'name' => $product_name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => new MongoDB\BSON\Binary($binaryData, MongoDB\BSON\Binary::TYPE_GENERIC),
    ]);
    echo "Product added successfully.";
}
