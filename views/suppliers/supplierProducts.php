<?php
# including files and classes used to select our data
include '../../controller/serverConnection.php';
include '../../navBar.php';

$id = $_GET['id'];

#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT products.product_id,products.product_name,product_supply.cost_price,product_supply.lead_time,round(products.stock) FROM products inner join product_supply on products.product_id = product_supply.product_id where product_supply.supplier_id='".$id."'";

# we pass this sql query to the server connection to get our infomation
$products = $db_conn->get($sql);

# creates the header of the table which will contain the previously collected data.
echo "<div id='stats-left'>".$id." Supplier Products</div>";
    echo "<div class = 'table-right'>";
    echo "<table id='table' style='width:50%'>
            <tr> 
                <th>ID</th> 
                <th>Name</th> 
                <th>Stock</th> 
                <th>Lead time</th> 
                <th>Price</th> 
            </tr>";

# foreach set of data in the returned array, we loop through and add it to a table row
foreach($products as $product)
{
    $product_id = $product[0];
    $product_name = $product[1];
    $product_stock = $product[4];
    $lead_time = $product[3];
    $cost_price = $product[2];

    echo "<tr> 
            <td>" . $product_id. "</td> 
            <td>" . $product_name. "</td> 
            <td> " . $product_stock. "</td> 
            <td> " . $lead_time. "</td> 
            <td> " . $cost_price. "</td> 
          </tr>";
}

echo "</table></div>";

?>