<?php
# including files and classes used to select our data
include '../../controller/serverConnection.php';
include '../../navBar.php';

# retrives the customer id from the page that sent the user here. 
$id = $_GET['id'];

#sql query used to retrive the infomation used to fill the page, this query selects all the products this specific customers uses with extra details. 
$sql = "SELECT *,ROUND((item_profit / sales_price) * 100,2) AS margin FROM
(
  SELECT *,round(total_stock*item_profit,2) AS total_profit,round(total_stock*sales_price,2)as total_revenue,round(total_stock*cost_price,2) as total_cost FROM
  (
    SELECT order_reference,t.product_id,product_name,t.sales_price,cost_price,sum(quantity) AS total_stock,round(t.sales_price - cost_price,2) AS item_profit from transactions as t INNER JOIN products AS p ON p.product_id=t.product_id WHERE customer_id='".$id."' AND quantity > 0 GROUP BY t.product_id,t.sales_price
  )
  AS t
)
AS f
ORDER BY total_profit desc";

# we pass this sql query to the server connection to get our infomation
$customer_products = $db_conn->get($sql);

#instating variables to prevent errors. 
$totalProfit = 0;
$totalSalePrice = 0;
$totalCostPrice = 0;

#creating the table header. 
echo "<div id='stats-left'></div>";
echo "<div class = 'table-right'>";
echo "<table id='table' style='width:50%'>
        <tr> 
          <th>ref</th> 
          <th>product Id</th>
          <th>Name</th> 
          <th>stock bought</th> 
          <th>sales price</th> 
          <th>cost price</th> 
          <th>item profit</th> 
          <th>total costs</th> 
          <th>Total revenue</th> 
          <th>total profit</th> 
          <th>margin</th> 
        </tr>";

#for each product the customer uses, we put it into a table
foreach($customer_products as $product)
{
  $order_reference = $product[0];
  $product_id = $product[1];
  $product_name = $product[2];
  $sales_price = $product[3];
  $cost_price = $product[4];
  $total_stock = $product[5];
  $item_profit = $product[6];
  $total_profit = $product[7];
  $total_revenue = $product[8];
  $total_cost = $product[9];
  $margin = $product[10];

  $totalProfit += $total_profit;
  $totalSalePrice += $total_revenue;
  $totalCostPrice += $total_cost;

  echo "<tr> 
          <td>".$order_reference."</td>
          <td>".$product_id."</td>
          <td>".$product_name."</td> 
          <td>".$total_stock."</td>
          <td>".$sales_price."</td> 
          <td>".$cost_price."</td> 
          <td>".$item_profit." </td>
          <td>".$total_cost." </td>
          <td>".$total_revenue."</td>
          <td>".$total_profit."</td> 
          <td>".$margin."</td> 
        </tr>";
}
#closes the table
echo "</table></div>";

#calls a js function which shows the profits and margins made from this customers
echo "<script type='text/javascript'>report_earnings(".$totalProfit.",".$totalSalePrice.",".$totalCostPrice.");</script>";

?>