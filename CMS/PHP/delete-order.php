<?php

include 'common.php';

$db_orders = $db->orders; // collection

// get data from post request and fetch it into variables.
$order_id = $_POST["orderId"];

// delete order from db
$db_orders->deleteOne(['orderId' => $order_id]);
