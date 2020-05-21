<?php
# including files and classes used to select our data
include '../../models/product.php';
include '../../controller/serverConnection.php';
include '../../navBar.php';

# retrives all the products from the db.
$products = $db_conn->get_products();

# creates the header of the table which will contain the previously collected data.
echo "<div id='stats-left'></div>";
echo "<div class = 'table-right'>";
echo "<table id='table' style='width:50%'>
        <tr> 
            <th><a href='products.php?id=id'>ID</a></th> 
            <th><a href='products.php?id=name'>Name</a></th> 
            <th><a href='products.php?id=stock'>Stock</a></th> 
            <th><a href='products.php?id=price'>Price</a></th> 
            <th>supply</th> 
            <th>History</th> 
            <th>customer Relation</th>
        </tr>";

# foreach set of data in the returned array, we loop through and add it to a table row
foreach($products as $product)
{
    echo "<tr onclick=getProduct(this,'".$product->get_id()."')> 
              <td>" . $product->get_id(). "</td> 
              <td>" . $product->get_name(). "</td>
              <td> " . $product->get_stock(). "</td> 
              <td> " . $product->get_price(). "</td> 
              <td><a href='productSupply.php?id=".$product->get_id()."'>Supply</a></td> 
              <td><a href='productHistory.php?id=".$product->get_id()."'>History</a></td> 
              <td><a href='productCustomerRelation.php?id=".$product->get_id()."'>Customer Report</a></td> 
          </tr>";
}

?>