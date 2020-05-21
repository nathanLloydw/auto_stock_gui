<?php
# including files and classes used to select our data
include '../../controller/serverConnection.php';
include '../../navBar.php';

$id = $_GET['id'];

#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT * FROM transactions WHERE Product_id='".$id."'";

# we pass this sql query to the server connection to get our infomation
$transactions = $db_conn->get($sql);

# creates the header of the table which will contain the previously collected data.
echo "<div id='stats-left'>".$id." Products History: </div>";
echo "<div class = 'table-right'>";
echo "<table id='table' style='width:50%'>
        <tr> 
            <th>ID</th> 
            <th>Stock</th> 
            <th>Date</th> 
        </tr>";

# foreach set of data in the returned array, we loop through and add it to a table row
foreach($transactions as $transaction)
{
    $product_id = $transaction[1];
    $quantity = $transaction[2];
    $date = $transaction[4];

    echo "<tr> 
            <td>".$product_id."</td> 
            <td>".$quantity."</td>  
            <td>".$date."</td>  
          </tr>";  
}

echo "</table></div>";

?>