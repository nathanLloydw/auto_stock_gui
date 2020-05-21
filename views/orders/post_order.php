<?php
# including files and classes used to select our data
include '../../controller/SDataConnection.php';
include '../../data/sdata_payloads.php';


$product = $_GET['product'];
$supplier = $_GET['supplier'];
$quantity = $_GET['quantity'];
$price = $_GET['price'];

echo $product." \n";
echo $supplier." \n";
echo $quantity." \n";
echo $price." \n";

$post_order = $sdata_conn->post_purchase_order($product,$supplier,$quantity,$price);

?>
