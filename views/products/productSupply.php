<?php
# including files and classes used to select our data
include '../../controller/serverConnection.php';
include '../../navBar.php';

$id = $_GET['id'];

#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT * FROM suppliers inner join product_supply on suppliers.supplier_id = product_supply.supplier_id where product_supply.product_id = '".$id."'";

# we pass this sql query to the server connection to get our infomation
$suppliers = $db_conn->get($sql);

# creates the header of the table which will contain the previously collected data.
echo "<div id='stats-left'>".$id." Product Supply</div>";
echo "<div class = 'table-right'>";
echo "<table id='table' style='width:50%'>
        <tr> 
            <th>ID</th> 
            <th>Name</th> 
            <th>Lead Time</th> 
            <th>Contact</th> 
            <th>Telephone</th> 
            <th>Email</th> 
        </tr>";

# foreach set of data in the returned array, we loop through and add it to a table row
foreach($suppliers as $supplier)
{
    $supplier_id = $supplier[0];
    $supplier_name = $supplier[1];
    $contact_name = $supplier[2];
    $contact_telephone = $supplier[4];
    $contact_email = $supplier[5];
    $lead_time = $supplier[8];

    echo "<tr> 
            <td>".$supplier_id."</td> 
            <td>".$supplier_name."</td> 
            <td>".$lead_time."</td> 
            <td>".$contact_name."</td> 
            <td>".$contact_telephone."</td> 
            <td>".$contact_email."</td>  
         </tr>";
}

echo "</table></div>";

?>