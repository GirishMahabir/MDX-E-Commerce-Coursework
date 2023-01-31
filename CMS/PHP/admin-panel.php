<?php
// Echoing the HTML code for the admin panel, top section.
echo "
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='../CSS/style.css'>
    <!-- Import Ajax Script. -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
    <script src='../JS/AJAX/ajax.js'></script>
    <!-- Google Fonts. -->
    <link href='https://fonts.googleapis.com/css?family=Lato:100italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
    <!-- Google Icon Link -->
    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    <title>Administration Panel</title>
</head>
<!-- Main Container -->

<body class='main-container'>
    <div class='header-02'>
        <!-- Header Section -->
        <img class='admin-logo-main' src='../ASSETS/admin-logo.png' alt='admin-logo'>
        <h1 class='admin-login-h1'>Admin Panel</h1>
    </div>
    <div class='section-break'>
        <!-- Section Break -->
        Products Management
    </div>
    <div class='products-section scroll-btn'>
        <!-- Products Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                </tr>
            </thead>
                <tbody>
            ";
// Grabbing the data from the database and printing it out in the table.
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

$db_products = $db->products; // collection

// for loop to print out the data from the database. "productId", "name", description", "price", "quantity"
// "image", should be link to load image.

$product_size = $db_products->count();

echo "<script>console.log('Product Size: $product_size');</script>";

// get all productIds
$products = $db_products->find();

$product_list = $products->toArray();

// for loop to print out the data from the database. "productId", "name", description", "price", "quantity"
// "image", should be link to load image, that when clied on, it will open the image in a new tab.
for ($i = 0; $i < $product_size; $i++) {
    $product_id = $product_list[$i]->productId;
    $product_name = $product_list[$i]->name;
    $product_description = $product_list[$i]->description;
    $product_price = $product_list[$i]->price;
    $product_quantity = $product_list[$i]->quantity;
    $product_image = $product_list[$i]->image;

    // convert image from binary to base64
    $base64Data_image = base64_encode($product_image->getData());
    // Create a data URL for the image
    $dataURL_image = 'data:' . $product_image->getType() . ';base64,' . $base64Data_image;

    // Download Image to local storage.
    $image_name = $product_id . '.jpg';
    $image_path = '../ASSETS/PRODUCTS/' . $image_name;
    file_put_contents($image_path, $product_image->getData());

    echo "
        <tr>
            <td>$product_id</td>
            <td>$product_name</td>
            <td>$product_description</td>
            <td>$product_price</td>
            <td>$product_quantity</td>
            <td><a href='$image_path' target='_blank'><i class='material-icons' id='icon'>image</i></a></td>
        </tr>
        ";
}

echo "
            </tbody>
        </table>
    </div>
    <br>
    <div class='section-break'>
        <!-- Section Break -->

        Update/Add Products
    </div>
    <br>
    <div class='admin-products-form'>
        <div class='apf-d01'>
            <label for='pid'>Product ID</label>
        </div>
        <div class='apf-d02'>
            <label for='product_name'>Product Name</label>
        </div>
        <div class='apf-d03'>
            <form method='post' enctype='multipart/form-data' id='imageform' a>
                <input name='UserImgFile' type='file' id='image' accept='image/jpeg, image/png, image/jpg'>
            </form>
            <!-- <input type='file' id='image' accept='image/jpeg, image/png, image/jpg'>  -->
        </div>
        <div>
            <output></output>
        </div>
    </div>
    <div class='admin-products-form'>
        <div class='apf-d04'>
            <input type='text' id='pid' name='pid' placeholder='P000' minlength='4' maxlength='4'>
        </div>
        <div class='apf-d05'>
            <input type='text' id='product_name' name='password'>
        </div>
    </div>
    <br> <br>
    <div class='admin-products-form'>
        <div class='apf-d06'>
            <label for='description'>Product Description</label>
        </div>
        <div class='apf-d07'>
            <label for='quantity'>Product Quantity</label>
        </div>
        <div class='apf-d071'>
            <label for='quantity'>Product Price</label>
        </div>
        <div class='apf-d08'>
            <button id='updateButton' type='button'>UPDATE</button>
        </div>
    </div>
    <br>
    <div class='admin-products-form'>
        <div class='apf-d09'>
            <textarea type='text' rows='4' cols='27' id='description' name='description'></textarea>
        </div>
        <div class='apf-d10'>
            <input type='number' id='quantity' name='quantity'>
        </div>
        <div class='apf-d101'>
            <input type='text' id='price' name='price'>
        </div>
        <div class='apf-d11'>
            <button id='addButton' type='button'>ADD</button>
        </div>
    </div>

    <br> <br>
    <div class='section-break'>
        <!-- Section Break -->
        Orders List
    </div>
";

echo "
    <!-- Orders Section -->
    <div class='products-section scroll-btn'>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>User Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
    ";


// get all orders from the database.
$db_orders = $db->orders; // collection
$orders_size = $db_orders->count();
$orders = $db_orders->find();

// get the user name from the database.
$db_users = $db->users; // collection

$orders_list = $orders->toArray();

// for loop to print out the data from the database. "orderId", User Name, Product Name, "quantity", Total Price
for ($i = 0; $i < $orders_size; $i++) {
    $order_id = $orders_list[$i]->orderId;
    $order_user_id = $orders_list[$i]->userId;
    $order_product_id = $orders_list[$i]->productId;
    $order_quantity = $orders_list[$i]->quantity;

    // get the user name from the database, using the user id.
    $user = $db_users->findOne(['userId' => $order_user_id]);
    $user_name = $user->name;
    $user_surname = $user->surname;
    $username = $user_name . ' ' . $user_surname;


    // get the product name from the database.
    $product = $db_products->findOne(['productId' => $order_product_id]);
    $product_name = $product->name;

    // get the product price from the database.
    $product_price = $product->price;

    // extract only the numbers from the price.
    $product_price = preg_replace('/[^0-9.]/', '', $product_price);

    // get the total price.
    $total_price = $product_price * $order_quantity;

    echo "
                <tr>
                    <td>$order_id</td>
                    <td>$product_name</td>
                    <td>$user_name</td>
                    <td>$order_quantity</td>
                    <td>$total_price</td>
                </tr>
    ";
}

echo "
            </tbody>
        </table>
    </div>
    <script src='../JS/admin-panel.js'></script>
</body>

</html>
";
