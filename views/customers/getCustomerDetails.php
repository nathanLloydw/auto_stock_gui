<?php
# including files and classes used to select our data
include '../../controller/serverConnection.php';

# retrives the customer id from the page that sent the user here. 
$id = $_GET['id'];

#sql query used to retrive the customer details.
$sql="SELECT * from customers WHERE customer_id='".$id."'";

# we pass this sql query to the server connection to get our infomation
$customers = $db_conn->get($sql);

# only one should be returned but its nested, this prints out all the infomation to put on show. 
foreach($customers as $customer)
{   
    $customer_id = $customer[1];
    $company_name = $customer[2];
    $address = $customer[4]." ".$customer[5]." ".$customer[6];
    $phone = $customer[9];

    echo $customer_id.'/';
    echo $company_name.'/';
    echo $address.'/';
    echo $phone.'/';
    
}

?>
