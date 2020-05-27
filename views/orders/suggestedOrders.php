<?php
# including files and classes used to select our data
echo "<link rel='stylesheet' href='../../css/suggested_order_styles.css'>";
include '../../controller/serverConnection.php';
include '../../navBar.php';

#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT P.product_id,S.supplier_id,round(stock),lead_time,tot_quantity AS Useage,round(stock-tot_quantity) AS future_stock,round(stock / (tot_quantity / lead_time) - lead_time) AS days_till_order,S.uuid AS s_uuid,P.uuid AS p_uuid,cost_price FROM
(
	SELECT PS.supplier_id,PS.product_id,PS.lead_time,sum(quantity) AS tot_quantity,date FROM product_supply AS PS 
	INNER JOIN
	(
	    SELECT product_id,SUM(quantity) AS quantity,delivery_date AS date FROM transactions WHERE quantity > 0 GROUP BY day(delivery_date),product_id 
	) 
	AS T ON PS.product_id=T.product_id AND DATE > ADDDATE(NOW(), - lead_time)
	GROUP BY supplier_id,product_id,lead_time
) AS T
INNER JOIN products AS P ON P.product_id=T.product_id
INNER JOIN suppliers AS S ON S.supplier_id=T.supplier_id";

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