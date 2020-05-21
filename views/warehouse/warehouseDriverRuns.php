<?php
echo "<link rel='stylesheet' href='../../css/driver_sheet_styles.css'>";

include '../../controller/serverConnection.php';
include '../../navBar.php';
include '../../data/Delivery_routes.php';

#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT C.customer_id,R.order_reference,C.company_name,C.address,C.town_city,C.post_code,R.order_weight,location,location_run_number,row_number FROM
        (
            select * from delivery_runs where DATE=CURRENT_DATE() ORDER BY location DESC,row_number
        )
        AS R
        INNER JOIN customers AS C
        ON C.customer_id=R.customer_id
        order by location DESC,row_number";

# we pass this sql query to the server connection to get our infomation
$runs = $db_conn->get($sql);

if(empty($runs))
{  
    $db_conn->post_runs($routes);
    #header("Refresh:0");
}
else
{
    $unknown = $db_conn->update_runs($routes);
}

$todays_locations = array_keys($routes[date("l")]);
array_push($todays_locations,'unknown');

$button_count = sizeof($todays_locations)+1;
$button_width= 100 / $button_count;

echo "<div id='stats-left'>    
      </div>
      <div class='table-right' id='warehouse_body'>
      <div>";

foreach($todays_locations as $location)
{
    echo "<button class='daily_locations' style='width:".$button_width."%;' onClick='changeTab(event,".'"'.$location.'"'.")'>".$location."</button>";
    $ordersArray3D[$location] =  array();
}

echo "<button class='daily_locations' style='width:".$button_width."%;' onClick='create_table(event)'><i class='fas fa-plus' style='font-size:20px;color:white;'> </i></button>";
echo "</div><br><br>";


$location = '';
$location_run_num = '';

foreach($runs as $run)
{
    $location_run_num = '';
    $previous_location = $location;
    $previous_location_run_num = $location_run_num;

    $customer_id = $run[0];
    $order_reference = $run[1];
    $company_name = $run[2];
    $address = $run[3];
    $town_city = $run[4];
    $post_code = $run[5];
    $weight = $run[6];
    $location = $run[7];
    $location_run_num = $run[8];
    $row = $run[9];


    if($location != $previous_location)
    {
        if($location_run_num != $previous_location_run_num)
        {
            echo "<table class='".$location."' id='".$location." ".$location_run_num."' style='display:none;margin-top:5px;'>
            <tbody>
            <tr> 
                <th>Run ".$location_run_num."</th>
                <th>customer ID</th> 
                <th>Order Reference</th> 
                <th>Name</th> 
                <th>Address</th> 
                <th>town/city</th> 
                <th>postCode</th>
                <th>weight</th>
            </tr>";
        }
    }
  
    echo "<tr id='".$location." 1 ".$row."' >
    <td onClick='copyRow(event,".'"'.$location.'",1,'.$row.")'>
       <i class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
     </td>  
     <td>".$customer_id."</td> 
     <td>".$order_reference."</td> 
     <td>".$company_name."</td> 
     <td>".$address."</td> 
     <td>".$town_city."</td> 
     <td>".$post_code."</td> 
     <td>".$weight."</td> 
   </tr>";
}

echo "<table class='unknown' id='unknown 1' style='display:none;margin-top:5px;'>
            <tbody>
            <tr> 
                <th></th>
                <th>customer ID</th> 
                <th>Order Reference</th> 
                <th>Name</th> 
                <th>Address</th> 
                <th>town/city</th> 
                <th>postCode</th>
                <th>weight</th>
            </tr>";


$count = 1;
if (!empty($unknown))
{
    foreach($unknown as $order)
    {
        $customer_id = $order[0];
        $order_reference = $order[1];
        $comany_name = $order[2];
        $address = $order[3];
        $town_city = $order[4];
        $post_code = $order[5];
        $weight = $order[6];

        echo "<tr id='unknown 1 ".$count."' >
        <td onClick='copyRow(event,'unknown',1,'.$count.)'>
        <i class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
        </td>  
        <td>".$customer_id."</td> 
        <td>".$order_reference."</td> 
        <td>".$comany_name."</td> 
        <td>".$address."</td> 
        <td>".$town_city."</td> 
        <td>".$post_code."</td> 
        <td>".$weight."</td> 
    </tr>";
    }
    }


?>