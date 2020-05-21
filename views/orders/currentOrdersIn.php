<?php
# including files and classes used to select our data
include '../../controller/serverConnection.php';
include '../../navBar.php';

#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT * FROM purchase_orders where order_status='On Order'";

# we pass this sql query to the server connection to get our infomation
$purchase_orders = $db_conn->get($sql);

# creates the header of the table which will contain the previously collected data.
echo "<div id='stats-left'></div>";
echo "<div class = 'table-right'>";
echo "<table id='table' style='width:50%'>
        <tr> 
            <th>ID</th> 
            <th>Order Date</th> 
            <th>Due Date</th> 
            <th>Supplier</th> 
            <th>product</th> 
            <th>Quantity</th> 
            <th>Status</th> 
        </tr>";

# foreach set of data in the returned array, we loop through and add it to a table row
foreach($purchase_orders as $purchase_order)
{
    $order_reference = $purchase_order[0];
    $order_status = $purchase_order[1];
    $order_date = $purchase_order[2];
    $due_date = $purchase_order[3];
    $user = $purchase_order[4];
    $supplier_id = $purchase_order[5];
    $product_id = $purchase_order[6];
    $order_quantity = $purchase_order[7];

    echo "<tr> 
            <td>".$order_reference."</td> 
            <td>".$order_date."</td> 
            <td>".$due_date."</td> 
            <td>".$supplier_id."</td> 
            <td>".$product_id."</td> 
            <td>".$order_quantity."</td> 
            <td>".$order_status."</td>  
        </tr>";
}

?>