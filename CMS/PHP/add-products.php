<?php
include 'common.php';

$db_products = $db->products; // collection

// get data from post request and fetch it into variables.
$pid = $_POST["pid"];
$product_name = $_POST["product_name"];
$description = $_POST["description"];
$price = $_POST["price"];
$quantity = $_POST["quantity"];

// image upload code
$target_dir = "../ASSETS/PRODUCTS/";
$banner = $_FILES["image"]["name"];
$FILE_SIZE_LIMIT = $_ENV['FILE_SIZE_LIMIT'];

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
    echo json_encode(array(
        "status" => "image_error",
        "message" => "Sorry, there was an error uploading your file."
    ));
}

// insert data into mongodb
// Check if pid already exists
$check = $db_products->findOne(['pid' => $pid]);
if ($check) {
    echo json_encode(array(
        "status" => "error",
        "message" => "Product ID already exists."
    ));
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
    echo json_encode(array(
        "status" => "success",
        "message" => "Product added successfully."
    ));

    // remove the file
    if (!unlink($bannerPath)) {
        error_log("$bannerPath cannot be deleted due to an error");
    } else {
        error_log("$bannerPath has been deleted", 0);
    }
}
