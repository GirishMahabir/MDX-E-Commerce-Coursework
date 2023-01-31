<?php
include 'common.php';

$db_products = $db->products; // collection

// get data from post request and fetch it into variables.
$pid = $_POST["pid"]; // compulsory

// Function to check if post request has a field and return the value of the post request it is was set
// or return the value of the field from the database.
function check_field($field_name, $pid, $db_products)
{
    if (isset($_POST[$field_name])) {
        return $_POST[$field_name];
    } else {
        // get the product name from the database.
        return $db_products->findOne(['productId' => $pid])[$field_name];
    }
}
$product_name = check_field("name", $pid, $db_products);
$description = check_field("description", $pid, $db_products);
$price = check_field("price", $pid, $db_products);
$quantity = check_field("quantity", $pid, $db_products);

// If image was uploaded, then get the image from the post request.
if (isset($_FILES["image"])) {
    $image = $_FILES["image"];
    // image upload code
    $target_dir = "../ASSETS/PRODUCTS/";
    $banner = $_FILES["image"]["name"];
    $FILE_SIZE_LIMIT = $_ENV['FILE_SIZE_LIMIT'];
    $bannerPath = $target_dir . $pid . "-" . basename($banner);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $bannerPath)) {
        // check if the file is an image:
        if (is_image($bannerPath)) {
            error_log("The file " . basename($banner) . " has been uploaded.", 0);
        } else {
            error_log("The file $bannerPath is not an image.");
            // remove the file:
            $delete_status = unlink($bannerPath);
            if ($delete_status) {
                error_log("The file $bannerPath has been deleted.", 0);
            } else {
                error_log("The file $bannerPath could not be deleted.");
            }
        }
    } else {
        echo "Sorry, there was an error uploading your file. Please try again";
    }
} else {
    // re-use the old image.
    $bannerPath = "../ASSETS/PRODUCTS/" . $pid . ".jpg";
}

// insert data into mongodb (image converted to binary)
$binaryData = file_get_contents($bannerPath);

// Update the product if it already exists.
$updateResult = $db_products->updateOne(
    ['productId' => $pid],
    ['$set' => [
        'name' => $product_name,
        'description' => $description,
        'price' => $price, 'quantity' => $quantity,
        'image' => new MongoDB\BSON\Binary($binaryData, MongoDB\BSON\Binary::TYPE_GENERIC)
    ]]
);
if ($updateResult->getModifiedCount() == 1) {
    echo "Product updated successfully.";
} else {
    echo "Product could not be updated.";
}
