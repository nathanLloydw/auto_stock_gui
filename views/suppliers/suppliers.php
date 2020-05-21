<?php
# including files and classes used to select our data
include '../../models/supplier.php';
include '../../controller/serverConnection.php';
include '../../navBar.php';

# retrives all the suppliers from the db.
$suppliers = $db_conn->get_suppliers();

# creates the header of the table which will contain the previously collected data.
echo "<div id='stats-left'></div>";
echo "<div class = 'table-right'>";
echo "<table id='table' style='width:50%'>
        <tr> 
            <th>ID</th> 
            <th>Name</th> 
            <th>products</th> 
        </tr>";

# foreach set of data in the returned array, we loop through and add it to a table row
foreach($suppliers as $supplier)
{
    echo "<tr onclick=getSupplier(this,'".$supplier->get_supplier_id()."','')>
            <td>".$supplier->get_supplier_id()."</td>
            <td>".$supplier->get_supplier_name()."</td>
            <td><a href='supplierProducts.php?id=".$supplier->get_supplier_id()."'>Products</a></td> 
          </tr>";
}

echo "</table></div>";

?>