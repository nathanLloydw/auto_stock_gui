<?php
# including files and classes used to select our data
include '../../controller/serverConnection.php';

# retrives the customer id from the page that sent the user here. 
$id = $_GET['id'];

#sql query used to retrive the infomation about the customer and ordering habits.
$sql="SELECT customer_id,max_date,min_date,orders,days_between_orders,predicted_next_order,0-DATEDIFF(NOW(),predicted_next_order) AS days_till_order FROM
(
  SELECT *,ADDDATE(max_date,days_between_orders) AS predicted_next_order FROM
  (
    SELECT *,DATEDIFF(max_date,min_date) / orders AS days_between_orders FROM
    (
      SELECT *,MAX(delivery_date) AS max_date,MIN(delivery_date) AS min_date,COUNT(DISTINCT order_reference) AS orders FROM
      (
        SELECT * FROM transactions WHERE customer_id='".$id."' GROUP BY order_reference
      )     
      AS f
      GROUP BY customer_id
    ) 
    as d
  )
  as q
)
AS n";

# we pass this sql query to the server connection to get our infomation
$customers = $db_conn->get($sql);

# only one should be returned but its nested, this prints out all the infomation to put on show. 
foreach($customers as $customer)
{
  $customer_id = $customer[0];
  $max_date = $customer[1];
  $min_date = $customer[2];
  $orders = $customer[3];
  $days_between_orders = $customer[4];
  $next_order_date = $customer[5];
  $days_till_order = $customer[6];

  echo $customer_id.'/';
  echo $max_date.'/';
  echo $min_date.'/';
  echo $orders.'/';
  echo $days_between_orders.'/';
  echo $next_order_date.'/';
  echo $days_till_order.'/';
}

?>
