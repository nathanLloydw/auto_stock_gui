<?php
# including files and classes used to select our data
include '../../controller/serverConnection.php';

$id = $_GET['customer'];
$code = $_GET['code'];
$notes = $_GET['notes'];
$opening_hour = $_GET['hour'];

#sql query used to update the infomation on the db.
$sql="update customers set status=".$code.", notes='".$notes."', opening_hour=".$opening_hour." where customer_id='".$id."'";

# we pass this sql query to the server connection to post our infomation
$db_conn->post($sql);

?>
