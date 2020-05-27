<?php

# including files and classes used to select our data
include '../../controller/serverConnection.php';

$customer = $_GET['customer'];
$location = $_GET['location'];
$run = $_GET['run_num'];
$row = $_GET['row'];
$date = $_GET['date'];

echo $customer;
echo $location;
echo $run;
echo $row;
echo $date;

$sql = "update delivery_runs set row_number=".$row.", location='".$location."', location_run_number=".$run." where customer_id='".$customer."' and date='".$date."'";

$db_conn->post($sql);
?>

