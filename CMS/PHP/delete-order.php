<?php

include 'common.php';

$db_orders = $db->orders; // collection

// get data from post request and fetch it into variables.
$order_id = $_POST["orderId"];

// delete order from db
$db_order = $db_orders->deleteOne(['orderId' => $order_id]);

if ($db_order->getDeletedCount() == 0) {
    echo json_encode(array(
        "status" => "error",
        "message" => "Order could not be deleted."
    ));
    exit();
} else if ($db_order->getDeletedCount() == 1) {
    echo json_encode(array(
        "status" => "success",
        "message" => "Item deteled."
    ));
    exit();
};
