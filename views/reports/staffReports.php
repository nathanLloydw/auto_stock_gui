<?php
# including files and classes used to select our data
echo "<link rel='stylesheet' href='../../css/staff_record_styles.css'>";
include '../../controller/serverConnection.php';
include '../../navBar.php';

#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT distinct allocation FROM customers ";

$range = "' AND quantity > 0 and delivery_date >= adddate(NOW(),-8)";
if (isset($_GET['range']))
{
    $filter = $_GET['range'];

    if ($filter == 0){$range = "' AND DATE >= adddate(NOW(),-1)";}
    else if($filter == 1){$range = "' AND DATE >= adddate(NOW(),-8)";}
    else if($filter == 2){$range = "' AND DATE >= adddate(NOW(),-29)";}
    else if($filter == 3){$range = "' AND DATE >= adddate(NOW(),-366)";}
    else if ($filter == 4){$range = "'";}
}

# we pass this sql query to the server connection to get our infomation
$allocations = $db_conn->get($sql);

# creates the header of the table which will contain the previously collected data.
echo "<div id='stats-left'></div>
      <div class = 'table-right'>
        <button class='clickable'><a href='staffReports.php?range=0'>Today</a></button> 
        <button class='clickable'> <a href='staffReports.php?range=1'>Past Week</a></button> 
        <button class='clickable'> <a href='staffReports.php?range=2'>Past Month </a></button> 
        <button class='clickable'> <a href='staffReports.php?range=3'>Past Year</a></button> 
        <button class='clickable'><a href='staffReports.php?range=4'>All Time</a></button>
            <table id='table' style='width:50%'>
                <tr>
                    <th>Name</th> 
                    <th>total price</th> 
                    <th>stock sent out</th> 
                    <th>total orders</th> 
                    <th>products sent out</th> 
                    <th>allocated customers sold to</th> 
                </tr>";

# foreach set of data in the returned array, we loop through and add it to a table row
foreach($allocations as $allocation)
{
    $allocation = $allocation[0];

    if ($allocation != "Helen" and $allocation != "Steve / Pedram" and $allocation != "Perco" and $allocation != ""  and $allocation != "Bad Debt" and $allocation != "Closed")
    {
        $sql2 = "SELECT SUM(quantity*sales_price),SUM(quantity),count(DISTINCT order_reference),count(DISTINCT product_id),count(DISTINCT c.customer_id) FROM customers c JOIN transactions AS o ON c.customer_id=o.customer_id  WHERE allocation='".$allocation.$range;

        $customers = $db_conn->get($sql2);

        foreach($customers as $customer)
        {
            $profit = $customer[0];
            $stock = $customer[1];
            $orders = $customer[2];
            $products = $customer[3];
            $customers = $customer[4];

            $money = explode(".",$profit);
            $stock = explode(".",$stock);
            echo "<tr>
                    <td>".$allocation."</td>
                    <td>".$money[0]."</td> 
                    <td>".$stock[0]."</td> 
                    <td>".$orders."</td> 
                    <td>".$products."</td> 
                    <td>".$customers."</td>
                  </tr>";
        }    
    }
}
echo "</table></div>";


?>