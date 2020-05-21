<?php
# including files and classes used to select our data
include '../../controller/serverConnection.php';

$id = $_GET['id'];

#sql query used to retrive the infomation used to fill the page.
$sql="SELECT SUM(quantity),COUNT(quantity),MIN(delivery_date) FROM transactions WHERE product_id='".$id."'";

# we pass this sql query to the server connection to get our infomation
$products_stats = $db_conn->get($sql);

foreach($products_stats as $product_stats)
{
    $sum = $product_stats[0];
    $count = $product_stats[1];
    $min = $product_stats[2];

    echo $sum.'-'.$count.'-'.$min;
}

?>