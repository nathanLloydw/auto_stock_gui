<?php
# including files and classes used to select our data
include '../../controller/serverConnection.php';
include '../../navBar.php';

#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT order_reference,t.product_id,product_name,cast(SUM(t.quantity)AS int) AS stock_sold,COUNT(t.quantity) AS times_sold,t.sales_price,cost_price,(SUM(t.quantity)*t.sales_price) - (SUM(t.quantity)*cost_price) AS product_profit 
        FROM transactions t 
        INNER JOIN products AS p ON t.product_id=p.product_id 
        WHERE 
        (
        t.user='ORCHARDS' OR t.customer_id='ORCHARD' OR t.customer_id='ORCHARDV'
        ) 
        AND 
        t.quantity > 0 
        GROUP BY 
        product_id,sales_price 
        order by (SUM(t.quantity)*t.sales_price) - (SUM(t.quantity)*cost_price) desc";

# we pass this sql query to the server connection to get our infomation
$products = $db_conn->get($sql);

$totalProfit = 0;
$totalSalePrice = 0;
$totalCostPrice = 0;

# creates the header of the table which will contain the previously collected data.
echo "<div id='stats-left'></div>";
echo "<div class = 'table-right'>";
echo "<table id='table' style='width:50%'>
        <tr> 
            <th>ref</th> 
            <th>ID</th> 
            <th>Name</th> 
            <th>stock sold</th> 
            <th>price</th>
            <th> cost price </th> 
            <th>revenue</th>
            <th> product Cost</th> 
            <th>profit</th> 
            <th>margin</th> 
        </tr>";

# foreach set of data in the returned array, we loop through and add it to a table row
foreach($products as $product)
{
    $margin = 0;
    $pounds = 0;
    $pence = 0;

    $order_reference = $product[0];
    $product_id = $product[1];
    $product_name = $product[2];
    $stock_sold = $product[3];
    $times_sold = $product[4];
    $sales_price = $product[5];
    $cost_price = $product[6];
    $product_profit = $product[7];

    $totalProfit += $product_profit;
    $totalSalePrice += ($sales_price*$stock_sold);
    $totalCostPrice += ($cost_price*$stock_sold);

    if($sales_price > 0)
    {
        $margins = substr((($sales_price - $cost_price) / $sales_price)*100,0,4);
        $pounds = explode(".",$product_profit)[0];
        $pence = 0;

        if(strpos($product_profit,'.'))
        {
            $pence = substr(explode(".",$product_profit)[1],0,2);  
        }
    }
    echo "<tr> 
            <td>".$order_reference."</td> 
            <td>" . $product_id. "</td> 
            <td>" . $product_name. "</td> 
            <td> " . $stock_sold. "</td>
            <td> " . $sales_price. "</td> 
            <td> " . $cost_price. "</td>
            <td> £" .($sales_price*$stock_sold). "</td>
            <td> £" .($cost_price*$stock_sold). "</td>
            <td> £" . $pounds.".".$pence."</td>
            <td> ".$margins."% </td>
          </tr>";
}

echo "</table>
      </div>
      <script type='text/javascript'>report_earnings(".$totalProfit.",".$totalSalePrice.",".$totalCostPrice.");</script>";
?>