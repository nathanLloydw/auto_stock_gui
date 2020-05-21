<?php
# including files and classes used to select our data
include '../../controller/serverConnection.php';

$id = $_GET['id'];

#sql query used to retrive the infomation used to fill the page.
$sql="SELECT contact_name,telephone,email FROM suppliers where supplier_id='".$id."'";

# we pass this sql query to the server connection to get our infomation
$suppliers = $db_conn->get($sql);

foreach($suppliers as $supplier)
{
    echo $supplier[0].' -';
    echo $supplier[1].' -';
    echo $supplier[2].' -';
}

?>
