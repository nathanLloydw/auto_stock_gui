<?php

# including files and classes used to select our data
include '../../models/customer.php';
include '../../controller/serverConnection.php';
include '../../navBar.php';

# retrives all the customers from the db.
$customers = $db_conn->get_customers();

#creates the header for the table the customers are put into.
echo "<div id='stats-left'></div>";
echo "<div class = 'table-right'>";
echo "<table id='table' style='width:50%'>
        <tr> 
            <th>ID</th> 
            <th>Name</th> 
            <th>allocation</th> 
            <th>customer Report</th> 
        </tr>";

#loops through each customer adding them into the table
foreach($customers as $customer)
{ 
    echo "<tr onclick=getCustomer(this,'".$customer->get_customer_id()."','')> 
            <td>" . $customer->get_customer_id(). "</td> 
            <td>" . $customer->get_customer_name(). "</td> 
            <td> " . $customer->get_allocation(). "</td> 
            <td><a href='customerProductRelation.php?id=".$customer->get_customer_id()."'>Customer Report</a></td>
        </tr>";
}   

#closes table
echo "</table></div>";

?>