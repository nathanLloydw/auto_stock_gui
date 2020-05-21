<?php
# including files and classes used to select our data
echo "<link rel='stylesheet' href='../../css/suggested_order_styles.css'>";
include '../../controller/serverConnection.php';
include '../../navBar.php';

#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT P.product_id,PS.supplier_id,round(stock) AS stock,lead_time,round(daily_useage*lead_time) AS lead_time_useage,round(stock - daily_useage*lead_time,2) AS predicted_stock,ROUND((stock/daily_useage)- lead_time) AS days_till_zero,S.uuid AS sup,P.uuid AS prod,PS.cost_price FROM products AS P
        INNER JOIN
        (
        SELECT product_id,round(SUM(quantity)/21,2) AS daily_useage FROM transactions WHERE delivery_date > ADDDATE(NOW(), -21) AND quantity > 0 GROUP BY product_id
        ) 
        AS T ON T.product_id=P.product_id
        INNER JOIN product_supply AS PS ON PS.product_id=P.product_id
        INNER JOIN suppliers AS S ON S.supplier_id=PS.supplier_id
        where stock > 0";

# we pass this sql query to the server connection to get our infomation
$suggested_orders = $db_conn->get($sql);

# creates the header of the table which will contain the previously collected data.
echo "<body onload='stockCheck()'>
        <div id='stats-left'></div>
        <div class = 'table-right'>
        <table id='table' style='width:50%'>
            <tr> 
                <th>ProductID</th> 
                <th>Supplier</th> 
                <th>Stock</th> 
                <th>LeadTime</th> 
                <th>stock useage in LeadTime</th> 
                <th>Days till order</th>
                <th>Predicted stock after leadTime</th>
                <th>Quantity</th>
                <th>Place Order</th>
            </tr>";

# foreach set of data in the returned array, we loop through and add it to a table row
foreach($suggested_orders as $suggested_order)
{
    $product_id = $suggested_order[0];
    $supplier_id = $suggested_order[1];
    $current_stock = $suggested_order[2];
    $lead_time = $suggested_order[3];
    $predicted_stock_useage = $suggested_order[4];
    $predicted_stock_after_lead_time = $suggested_order[5];
    $daysTillOrder = $suggested_order[6];
    $supplier_uuid = $suggested_order[7];
    $product_uuid = $suggested_order[8];
    $cost_price = $suggested_order[9];

    echo "<tr> 
            <td>".$product_id."</td> 
            <td>".$supplier_id."</td>
            <td>".$current_stock."</td> 
            <td>".$lead_time."</td> 
            <td>".$predicted_stock_useage."</td> 
            <td>".$daysTillOrder."</td>  
            <td>".$predicted_stock_after_lead_time."</td> 
            <td> <input id='".$supplier_uuid."-".$product_uuid."' type='text' name='fname' style='width:35px;height:19px;'></td> 
            <td> <i class='fas fa-check-square' id='order-".$supplier_uuid."-".$product_uuid."' style='font-size:22px;' onclick=post_order(event,'".$product_uuid."','".$supplier_uuid."','".$cost_price."')> </i></td> 
          </tr>";

}

echo "</table></div></body>";

?>