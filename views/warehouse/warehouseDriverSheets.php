<?php
echo "<link rel='stylesheet' href='../../css/driver_sheet_styles.css'>";

include '../../controller/serverConnection.php';
include '../../navBar.php';
include '../../data/Delivery_routes.php';

#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT c.customer_id,GROUP_CONCAT(order_reference) AS order_reference,c.company_name,c.address,c.town_city,c.post_code,sum(order_weight) AS order_weight FROM
        (
            SELECT order_reference,customer_id,delivery_date,t.product_id,sum(weight) AS order_weight FROM
            (
                SELECT order_reference,customer_id,delivery_date,product_id FROM 
                transactions WHERE delivery_date >= ADDDATE(NOW(),-1) AND delivery_date < ADDDATE(NOW(),0) AND customer_id != 'ORCHARD'
            )
            AS T
            INNER JOIN products AS P ON p.product_id=t.product_id
            GROUP BY order_reference
        ) 
        AS o
        INNER JOIN customers AS c ON c.customer_id=o.customer_id
        GROUP BY customer_id
        ORDER BY town_city desc";

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
echo "</div>";

$keys = $routes[date("l")];

# we pass this sql query to the server connection to get our infomation
$orders = $db_conn->get($sql);

foreach($orders as $order)
{
    $customer_id = $order[0];
    $order_reference = $order[1];
    $customer_name = $order[2];
    $address = $order[3];
    $town_city = $order[4];
    $post_code = str_replace(' ', '', $order[5]);
    $order_weight = $order[6];
    
    $order = array($customer_id,$order_reference,$customer_name,$address,$town_city,$post_code,$order_weight);

    $unknown = true;
    $orderKey = 'unknown';
    foreach ($keys as $key => $value)
    {
        $possible_postcodes = explode(',',$value);
        foreach($possible_postcodes as $possible_post_code)
        {
            if (strpos($post_code,$possible_post_code)!== false)
            {
                $ordersArray = $ordersArray3D[$key];
                $orderKey = $key;

                $unknown = false;
                break;
            }
        }
    }

    if ($unknown)
    {
        $ordersArray = $ordersArray3D['unknown'];
    }

    array_push($ordersArray,$order);      
    $ordersArray3D[$orderKey] = $ordersArray;
}

$count = 0;

foreach($ordersArray3D as $ordersArray)
{
    $key = $todays_locations[$count];
    echo "<table class='".$key."' id='".$key." 1' style='display:none;margin-top:5px;'>
            <tbody>
            <tr> 
                <th>Run 1</th>
                <th>customer ID</th> 
                <th>Order Reference</th> 
                <th>Name</th> 
                <th>Address</th> 
                <th>town/city</th> 
                <th>postCode</th>
                <th>weight</th>
            </tr>";

    $rowCount = 1;
    $totalWeight = 0;

    foreach($ordersArray as $order)
    {
        $customer_id = $order[0];
        $order_reference = $order[1];
        $name = $order[2];
        $address = $order[3];
        $town_city = $order[4];
        $post_code = $order[5];
        $weight = round($order[6],2);

        echo "<tr id='".$key." 1 ".$rowCount."' >
               <td onClick='copyRow(event,".'"'.$key.'",1,'.$rowCount.")'>
                  <i class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
                </td>  
                <td>".$customer_id."</td> 
                <td>".$order_reference."</td> 
                <td>".$name."</td> 
                <td>".$address."</td> 
                <td>".$town_city."</td> 
                <td>".$post_code."</td> 
                <td>".$weight."kg</td> 
              </tr>";
        $rowCount = $rowCount + 1;
        $totalWeight = $totalWeight + $weight;



    } 

    echo "<tr id='".$key." 1 ".$rowCount."' >
               <td onClick='copyRow(event,".'"'.$key.'",1,'.$rowCount.")'>
                  <i class='fas fa-copy' style='font-size:18px;padding-left:12px;'> </i>
                </td>  
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td></td> 
                <td>".$totalWeight."kg</td> 
              </tr>";
    echo "</tbody></table>";  
    
    $count = $count + 1; 
}
echo "</div>";

?>