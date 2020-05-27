<?php
echo "<link rel='stylesheet' href='../../css/driver_sheet_styles.css'>";

include '../../controller/serverConnection.php';
include '../../navBar.php';
include '../../data/Delivery_routes.php';

if (isset($_GET['date']))
{
    $date = '20'.$_GET['date'];
}
else
{
    $date = '20'.date("y-m-d");
}

#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT C.customer_id,R.order_reference,C.company_name,C.address,C.town_city,C.post_code,R.order_weight,location,location_run_number,row_number FROM
        (
            select * from delivery_runs where DATE='".$date."' ORDER BY location DESC,row_number
        )
        AS R
        INNER JOIN customers AS C
        ON C.customer_id=R.customer_id
        order by location DESC,location_run_number asc,row_number asc";

# we pass this sql query to the server connection to get our infomation

$runs = $db_conn->get($sql);
$day = date("l",strtotime($date));

if(empty($runs) && $day != 'Sunday')
{  
    $are_runs = $db_conn->post_runs($routes,$date);
    if($are_runs)
    {
           header("Refresh:0"); 
    }
}
else if($date >= date("yy-m-d") && $date != 'Sunday')
{
    $unknown = $db_conn->update_runs($routes,$date);
}


$todays_locations = array_keys($routes[date("l",strtotime($date))]);
array_push($todays_locations,'unknown');

$button_count = sizeof($todays_locations)+1;
$button_width= 100 / $button_count;

echo "<div id='stats-left'>   
        <button class='call_list_day_selection'><a href='warehouseDriverRuns.php?date=".date("y-m-d",strtotime($date."-1 days"))."'>previous day</a></button>
        ".$date."
        <button class='call_list_day_selection'><a href='warehouseDriverRuns.php?date=".date("y-m-d",strtotime($date."+1 days"))."'>following day</a></button>
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


    if($location != $previous_location || $location_run_num != $previous_location_run_num)
    {
        echo "<table class='".$location."' id='".$location." ".$location_run_num."' style='display:none;margin-top:5px;'>
        <tbody>
        <tr> 
            <th>Run ".$location_run_num."</th>
            <th>Customer ID</th> 
            <th>Order Reference</th> 
            <th>Address</th> 
            <th>Town/City</th> 
            <th>Post Code</th>
            <th><button id='weight ".$location." ".$location_run_num."' onclick='updateWeight(".'"'.$location.'"'.",".$location_run_num.")'>0.0KG</button></th>
            <th><button onclick='printRun(".'"'.$location.'"'.",".$location_run_num.")'>Print Run</button></th>
        </tr>";
    }

     echo "<tr id='".$location." ".$location_run_num." ".$row."' >
     <td>
       <input type='text' id='input-".$location."-".$location_run_num."-".$row."' name='fname' value='".$row."' style='width:25px;height:19px;'>
       <i onClick='moveRow(event,".'"'.$location.'"'.", ".$location_run_num.", ".$row.",".'"'.$date.'"'.")' class='fas fa-check-circle' style='font-size:18px;padding-left:12px;'> </i>
     </td>  
     <td>".$customer_id."</td> 
     <td>".$order_reference."</td> 
     <td>".$address."</td> 
     <td>".$town_city."</td> 
     <td>".$post_code."</td> 
     <td>".$weight."</td> 
     <td style='width:50px;'>
       <i onClick='copyRow(event,".'"'.$location.'",'.$location_run_num.",".$row.",".'"'.$date.'"'.")' class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
     </td>
   </tr>";
}

echo "<table class='unknown' id='unknown 1' style='display:none;margin-top:5px;'>
            <tbody>
            <tr> 
                <th></th>
                <th>Customer ID</th> 
                <th>Order Reference</th> 
                <th>Address</th> 
                <th>Town/City</th> 
                <th>Post Code</th>
                <th>Weight</th>
                <th>Print Run</th> 
            </tr>";


$row = 1;
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

        echo "<tr id='unknown 1 ".$row."' >
        <td> 
            <input type='text' name='fname' value='' style='width:25px;height:19px;'>
            <i class='fas fa-check-circle' style='font-size:18px;padding-left:12px;'> </i></td>
        <td>".$customer_id."</td> 
        <td>".$order_reference."</td> 
        <td>".$address."</td> 
        <td>".$town_city."</td> 
        <td>".$post_code."</td> 
        <td>".$weight."</td> 
          <td style='width:50px;'>
        <i onClick='copyRow(event,".'"unknown"'.",1,".$row.")' class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
        </td>
    </tr>";
    $row = $row + 1;
    }
}


?>