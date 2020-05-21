<?php
# including files and classes used to select our data
echo "<link rel='stylesheet' href='../../css/call_list_styles.css'>";
include '../../controller/serverConnection.php';
include '../../navBar.php';
include '../../data/Delivery_routes.php';
       
#sql query used to retrive the infomation used to fill the page.
$sql = "SELECT customer_id,company_name,last_order_ref,last_order_date,address,town_city,post_code,STATUS,notes,DATEDIFF(NOW(),last_order_date) AS days_since_order,opening_hour 
FROM customers
WHERE left(customer_id,2)!='ZZ'
ORDER BY STATUS DESC,days_since_order,post_code";

$day = date("w");

$active_route = '';

if (isset($_GET['day']))
{
    $day = $_GET['day'];
}


if ($day == 0){$day = 'Monday';}
else if($day == 1){$day = 'Tuesday';}
else if($day == 2){$day = 'Wednesday';}
else if($day == 3){$day = 'Thursday';}
else if ($day == 4){$day = 'Friday';}
else if ($day == 5){$day = 'Saturday';}


if (isset($_GET['route']))
{
    $active_route = $_GET['route'];
}

$todays_locations = array_keys($routes[$day]);
array_push($todays_locations,'other');

$button_count = sizeof($todays_locations);
$button_width= 100 / $button_count;

$keys = $routes[$day];

echo "<div id='stats-left'>
        <div id='stats-left-buttons'>";

echo "      <button class='call_list_days'><a href='ordersCallList.php?day=0'>Monday</a></button>
            <button class='call_list_days'><a href='ordersCallList.php?day=1'>Tuesday</a></button>
            <button class='call_list_days'><a href='ordersCallList.php?day=2'>Wednesday</a></button>
            <button class='call_list_days'><a href='ordersCallList.php?day=3'>Thursday</a></button>
            <button class='call_list_days'><a href='ordersCallList.php?day=4'>Friday</a></button>
            <button class='call_list_days'><a href='ordersCallList.php?day=5'>Saturday</a></button>";

echo"   </div>
        <div id='stats-left details' style='margin-top:10px;'></div>
      </div>
      <div class='table-right'><div class='tabs-holder' style='display:table;width:100%;'>";

foreach($todays_locations as $location)
{
    echo "<button class='call_list_locations ".$location."' style='width:".$button_width."%;' onClick='changeCallListTab(event,".'"'.$location.'"'.")'>".$location."</button>";
    $ordersArray3D[$location] =  array();
}

echo "</div>";

# we pass this sql query to the server connection to get our infomation
$customers = $db_conn->get($sql);

foreach($customers as $customer)
{    
    $customer_id = $customer[0];
    $customer_name = $customer[1];
    $last_order_ref = $customer[2];
    $address = $customer[4];
    $town_city = $customer[5];
    $post_code = str_replace(' ', '', $customer[6]);
    $status = $customer[7];
    $notes = $customer[8];
    $days_since_order = $customer[9];
    $opening_hour = $customer[10];

    $order = array($customer_id,$customer_name,$address,$town_city,$post_code,$status,$notes,$last_order_ref,$days_since_order,$opening_hour);

    $unknown = true;
    $orderKey = 'other';
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
        $ordersArray = $ordersArray3D['other'];
    }

    array_push($ordersArray,$order);      
    $ordersArray3D[$orderKey] = $ordersArray;
}

$count = 0;
foreach($ordersArray3D as $ordersArray)
{
    $key = $todays_locations[$count];

    if($active_route == $key)
    {
        echo "<table id='".$key."' class='tabcontent' style=display:table;margin-top:5px;'>";
    }
    else
    {
        echo "<table id='".$key."' class='tabcontent' style=display:none;margin-top:5px;'>";
    }
        echo "<tr> 
                <th>Customer ID</th> 
                <th>Post Code</th> 
                <th>Notes</th>
                <th>Ordered?</th>
                <th>Active</th>
                <th>D.N.C</th>   
              </tr>";

    
    foreach($ordersArray as $order)
    {
        $customer_id = $order[0];
        $customer_name = $order[1];
        $address = $order[2];
        $town_city = $order[3];
        $post_code = $order[4];
        $status = $order[5];
        $notes = $order[6];
        $last_order_ref = $order[7];
        $days_since_order = $order[8];
        $opening_hour = $order[9];

        $extention = 'AM';
        if($opening_hour == '' || $opening_hour == '0'){$opening_hour='unknown';$extention='';}

        if($opening_hour > 12)
        {
            $extention = 'PM';
            $opening_hour = $opening_hour - 12;
        }

        echo "<tr onclick=get_customer_details(this,'".$customer_id."','".$key."')>
                <td>" . $customer_id. "</td> 
                <td>" . $post_code. "</td> 
                <td style='position: relative;'> 
                    <select id='".$customer_id."_opening_hour'>";

        if($opening_hour == 0)
        {
            echo  "<option value='0'>unknown</option>";
        }
        else
        {
            echo "<option value='".$opening_hour."'>".$opening_hour." ".$extention."</option>
            <option value='0'>unknown</option>";
        }

        echo "          <option value='10'>10AM </option>
                        <option value='11'>11AM</option>
                        <option value='12'>12AM</option>
                        <option value='13'>1PM</option>
                        <option value='14'>2PM</option>
                        <option value='15'>3PM</option>
                        <option value='16'>4PM</option>
                        <option value='17'>5PM</option>
                        <option value='18'>6PM</option>
                    </select>
                     <input type='text' id='".$customer_id."' name='fname' value='".$notes."' style='width:250px;height:19px;'>
                     <i onclick=post_customer_status('".$customer_id.",".$status.",".$key."') class='fas fa-save' style='font-size:21px;padding-left:5px;bottom:11px;position: absolute;'> </i>
                </td>";

        if($status == 2)
        {
            echo " <td style='color:gray;font-weight:bold;'>".$last_order_ref."  <i onclick=post_customer_status('".$customer_id.",2,".$key."') class='fas fa-thumbs-up' style='font-size:22px;color:green;padding-right:32px;'> </i> </td>";  
            echo " <td style='color:gray;font-weight:bold;'> ".$days_since_order."  <i onclick=post_customer_status('".$customer_id.",2,".$key."') class='fas fa-thumbs-up' style='font-size:22px;color:green;'> </i> </td>";
            echo " <td> <i onclick=post_customer_status('".$customer_id.",0,".$key."') class='fas fa-times' style='font-size:22px;'> </i></td></tr>";        
        }
        else if($status == 3)
        {
            echo " <td> <i onclick=post_customer_status('".$customer_id.",2,".$key."') class='fas fa-thumbs-down' style='font-size:22px;color:red;padding-right:26px;'> </i> </td>";
            echo " <td style='color:gray;font-weight:bold;'> ".$days_since_order."  <i onclick=post_customer_status('".$customer_id.",2,".$key."') class='fas fa-thumbs-up' style='font-size:22px;color:green;'> </i> </td>";
            echo " <td> <i onclick=post_customer_status('".$customer_id.",0,".$key."') class='fas fa-times' style='font-size:22px;'> </i></td></tr>";
        }
        else if($status == 0)
        {
            echo " <td> <i onclick=post_customer_status('".$customer_id.",2,".$key."') class='far fas fa-spinner' style='font-size:22px;color:orange'> </i> </td>";  
            echo " <td style='color:gray;font-weight:bold;'> ".$days_since_order."  <i onclick=post_customer_status('".$customer_id.",2,".$key."') class='fas fa-spinner' style='font-size:22px;color:orange;'> </i> </td>";
            echo " <td> <i onclick=post_customer_status('".$customer_id.",4,".$key."') class='fas fa-check' style='font-size:22px;'> </i></td></tr>";
        }
        else if($status == 1)
        {
            echo " <td> <i onclick=post_customer_status('".$customer_id.",3,".$key."') class='far fa-thumbs-down' style='font-size:22px;'> </i> 
                        <i onclick=post_customer_status('".$customer_id.",3,".$key."') class='far fa-thumbs-up' style='font-size:22px;'> </i> 
                   </td>";
            echo " <td style='color:gray;font-weight:bold;'> ".$days_since_order."  <i onclick=post_customer_status('".$customer_id.",3,".$key."') class='fas fa-thumbs-down' style='font-size:22px;color:red;'> </i> </td>";
            echo " <td> <i onclick=post_customer_status('".$customer_id.",0,".$key."') class='fas fa-times' style='font-size:22px;'> </i></td></tr>";
        }
        else
        {
            echo " <td> <i onclick=post_customer_status('".$customer_id.",3,".$key."') class='far fa-thumbs-down' style='font-size:22px;'> </i> 
                        <i onclick=post_customer_status('".$customer_id.",2,".$key."') class='far fa-thumbs-up' style='font-size:22px;'> </i> 
                   </td>";
            echo " <td style='color:gray;font-weight:bold;'> ".$days_since_order."  <i onclick=post_customer_status('".$customer_id.",2,".$key."') class='fas fa-thumbs-up' style='font-size:22px;color:green;'> </i> </td>";
            echo " <td> <i onclick=post_customer_status('".$customer_id.",0,".$key."') class='fas fa-times' style='font-size:22px;'> </i></td></tr>";
        }
    } 
    echo "</table>";  
    
    $count = $count + 1; 
}
echo "</div>";

?>