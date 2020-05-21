<?php
# including files and classes used to select our data
include '../../controller/serverConnection.php';
include '../../navBar.php';

if (isset($_GET['id']))
{
    $id = $_GET['id'];
}

#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT *,(0 - DATEDIFF(NOW(),predicted_next_order)) AS days_till_order FROM 
(
  SELECT product_name,product_id,sum(sum_stock) AS total_ordered_quantity,sum_stock AS last_order_quantity,customer_id,orders_placed + COUNT(*) AS total_orders,MAX(delivery_date) AS max_date,MIN(delivery_date) AS min_date,ADDDATE(MAX(delivery_date),DATEDIFF(MAX(delivery_date),MIN(delivery_date)) / COUNT(*)) AS predicted_next_order,DATEDIFF(MAX(delivery_date),MIN(delivery_date)) / COUNT(*) AS average_days_between_orders FROM 
  (   
    SELECT lead_time,p.stock AS in_stock,product_name,order_reference,p.product_id,t.quantity,SUM(t.quantity) AS sum_stock,delivery_date,customer_id,COUNT(*) AS orders_placed FROM 
	  transactions t 
	  inner JOIN 
	  (
	    SELECT ps.product_id,product_name,stock,lead_time FROM products p 
		  INNER JOIN 
		  product_supply AS ps ON p.product_id=ps.product_id GROUP BY ps.product_id,Lead_time
	  ) 
	  AS p ON p.product_id=t.product_id GROUP BY t.product_id,t.customer_id,delivery_date HAVING t.quantity > 0
  ) 
  AS t GROUP BY product_id,customer_id 
) 
AS final WHERE product_id='".$id."' order by days_till_order asc";

# we pass this sql query to the server connection to get our infomation
$customers = $db_conn->get($sql);

# creates the header of the table which will contain the previously collected data.
echo "<div id='stats-left'></div>
      <div class = 'table-right'>
      <table id='table' style='width:50%'>
        <tr> 
          <th>ID</th> 
          <th>total orders places</th> 
          <th>first order placed</th> 
          <th>last order placed</th> 
          <th>average days between orders</th> 
          <th>estimated next order</th> 
          <th>days till predicted next order</th>
          <th>last order quantity</th> 
          <th>total order quantity</th> 
        </tr>";


# foreach set of data in the returned array, we loop through and add it to a table row
foreach($customers as $customer)
{
  $total_ordered_quantity = $customer[2];
  $last_ordered_quantity = $customer[3];
  $customer_id = $customer[4];
  $orders_placed = $customer[5];
  $min_date = $customer[6];
  $max_date = $customer[7];
  $predicted_next_order = $customer[8];
  $average_days_between_orders = $customer[9];
  $days_till_order = $customer[10];

  echo "<tr>
          <td>".$customer_id."</td> 
          <td>".$orders_placed."</td> 
          <td>".substr($min_date,0,10)."</td> 
          <td>".substr($max_date,0,10)."</td> 
          <td>".round($average_days_between_orders)."</td>  
          <td>".substr($predicted_next_order,0,10)."</td> 
          <td>".$days_till_order."</td> 
          <td>".$last_ordered_quantity."</td> 
          <td>".$total_ordered_quantity."</td> 
        </tr>";
}

echo "</table></div>";

?>