<?php

#if true use testing data set
$testing = False;

if($testing){$database = "autoStockTest";}
else{$database = "autoStock";}

$server = "192.168.1.94";
$port = 3306;
$user = "root";
$pass = "TheOfficePeople";


$db_conn = new db_conn($server,$port,$database,$user,$pass);

class db_conn
{
    private $connection;

    function __construct($server,$port,$database,$user,$pass)
    {
        $this->connection = new mysqli($server, $user, $pass,$database);

        if ($this->connection->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }
    }

    function get_products()
    {
        $sql = "select * from products";
        $products_sql_return = $this->get($sql);
        $products = [];
        foreach($products_sql_return as $product)
        {
            $product = new product($product[1],$product[2],$product[5],$product[3]);
            array_push($products,$product);
        }
        return $products;
    }

    function get_customers()
    {
        $sql = "select * from customers";
        $customers_sql_return = $this->get($sql);
        $customers = [];
        foreach($customers_sql_return as $customer)
        {
            $customer = new customer($customer[1],$customer[2],$customer[3],$customer[4],$customer[5],$customer[6],$customer[9]);
            array_push($customers,$customer);
        }
        return $customers;
    }

    function get_suppliers()
    {
        $sql = "select * from suppliers";
        $suppliers_sql_return = $this->get($sql);
        $suppliers = [];
        foreach($suppliers_sql_return as $supplier)
        {
            $supplier = new supplier($supplier[1],$supplier[2],$supplier[4],$supplier[5],$supplier[6]);
            array_push($suppliers,$supplier);
        }
        return $suppliers;
    }

    function get($sql)
    {
        $objects = array();
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                array_push($objects,array_values($row));
            }
        }
        return $objects;
    }

    function post($sql)
    {
        if ($this->connection->query($sql) != TRUE) 
        {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }

    function get_runs($sql,$routes)
    {
        $todays_destinations = array_keys($routes[date("l")]);
        array_push($todays_destinations,'unknown');

        foreach($todays_destinations as $destination)
        {
            $Runs[$destination] =  array();
        }

        $keys = $routes[date("l")];

        $orders_out = $this->get($sql);

        foreach($orders_out as $order_out)
        {
            $customer_id = $order_out[0];
            $order_reference = $order_out[1];
            $customer_name = $order_out[2];
            $address = $order_out[3];
            $town_city = $order_out[4];
            $post_code = str_replace(' ', '', $order_out[5]);
            $order_weight = $order_out[6];

            $destination = 'unknown';

            foreach ($keys as $location => $value)
            {
                $possible_postcodes = explode(',',$value);
                foreach($possible_postcodes as $possible_post_code)
                {
                    if (strpos($post_code,$possible_post_code)!== false)
                    {
                        $destination = $location;
                        break;
                    }
                }
            }
            $order = array($customer_id,$order_reference,$customer_name,$address,$town_city,$post_code,$order_weight,$destination);

            $orders = $Runs[$destination];
            array_push($orders,$order);      
            $Runs[$destination] = $orders;
        }
        return $Runs;

    }

    function post_runs($routes)
    {
        $sql = "SELECT c.customer_id,order_reference,c.company_name,c.address,c.town_city,c.post_code,round(order_weight,2) AS order_weight FROM
        (
           SELECT order_reference,customer_id,delivery_date,t.product_id,sum(weight) AS order_weight FROM
           (
               SELECT order_reference,customer_id,delivery_date,product_id FROM 
               transactions WHERE delivery_date=CURRENT_DATE()
           )
           AS T
           INNER JOIN products AS P ON p.product_id=t.product_id
           GROUP BY order_reference
        ) 
        AS o
        INNER JOIN customers AS c ON c.customer_id=o.customer_id
        ORDER BY post_code desc";

        $Runs = $this->get_runs($sql,$routes);

        foreach($Runs as $run)
        {
            $count = 1;
            echo "<br><br>";
            foreach($run as $order)
            {
                echo "<br>";
                print_r($order);
                echo "<br>";
                $location = $order[7];
                if($location != 'unknown')
                {
                    $customer_id =$order[0];
                    $invoice = $order[1];
                    $weight = $order[6];
                    $sql = "INSERT INTO delivery_runs (DATE,location,location_run_number,row_number,customer_id,order_reference,order_weight) 
                    VALUES (CURRENT_DATE(),'".$location."',1,".$count.",'".$customer_id."',".$invoice.",".$weight.")";
                    $count = $count + 1;
                    #$this->post($sql);
                } 
            }
        }
    }

    function update_runs($routes)
    {
        $sql = "SELECT C.customer_id,order_reference,C.company_name,address,town_city,post_code,round(sum(P.weight),2) AS weight FROM
        (
           SELECT T.order_reference,T.customer_id,T.delivery_date,T.product_id FROM
           (
               SELECT order_reference,customer_id,delivery_date,product_id FROM  
               transactions WHERE delivery_date = CURRENT_DATE()
           ) 
           AS T
           LEFT JOIN
           (
               SELECT * FROM delivery_runs WHERE DATE=CURRENT_DATE()
           )
           AS R
           ON R.order_reference=T.order_reference
           WHERE R.order_reference IS NULL
        ) 
        AS O
        INNER JOIN products AS P ON O.product_id=P.product_id
        INNER JOIN customers AS C ON O.customer_id=C.customer_id
        GROUP BY order_reference";

        $Runs = $this->get_runs($sql,$routes);

        $unknown = array();

        foreach($Runs as $run)
        {
            foreach($run as $order)
            {
                $location = $order[7];

                if($location != 'unknown')
                {
                    $customer_id =$order[0];
                    $invoice = $order[1];
                    $weight = $order[6];
                    $sql = "SELECT MAX(row_number) FROM delivery_runs WHERE location='".$location."' AND DATE=CURRENT_DATE()";
                    $row_number = $this->get($sql)[0][0]+1;
                    $sql = "INSERT INTO delivery_runs (DATE,location,location_run_number,row_number,customer_id,order_reference,order_weight) 
                    VALUES (CURRENT_DATE(),'".$location."',1,".$row_number.",'".$customer_id."',".$invoice.",".$weight.")";
                    $this->post($sql);
                }
                else
                {
                    array_push($unknown,$order);
                } 
            }
        }

        return $unknown;
    }
}
?>