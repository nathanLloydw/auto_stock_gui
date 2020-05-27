<?php

$auth_user = 'helen';
$auth_pass = 'helen';
$base_url = "http://192.168.1.200:5495/sdata/accounts50/gcrm/{E07F67FB-A27A-49AB-BBBB-1EDEBA388DB5}-1/";

$sdata_conn = new sdata_connection($base_url,$auth_user,$auth_pass);


class sdata_connection
{
    private $base_url;
    private $auth_user;
    private $auth_pass;

    function __construct($base_url,$auth_user,$auth_pass)
    {
        $this->base_url = $base_url;
        $this->auth_user = $auth_user;
        $this->auth_pass = $auth_pass;
    }

    function HTTPGetRequest($URL)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/xml",
                "Authorization: Basic aGVsZW46aGVsZW4="
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function HTTPPostRequest($URL,$Payloud)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$Payloud,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/atom+xml; type=entry",
                "Authorization: Basic aGVsZW46aGVsZW4="    
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
        echo '<br>post function complete';
    }

    function get_customer_by_id($customer_id)
    {
        $URL = $this->base_url."tradingAccountCustomer?where=reference%20eq%20'".$customer_id."'&format=json";
        $customer = $this->HTTPGetRequest($URL);
        return $customer;
    }

    function post_order_invoice($Payloud)
    {
        $URL = $this->base_url."salesInvoices";
        $post_return = $this->HTTPPostRequest($URL,$Payloud);
        return $post_return;
    }

    function post_purchase_order_test($Payloud)
    {
        $URL = $this->base_url."purchaseOrders";
        $post_return = $this->HTTPPostRequest($URL,$Payloud);
        return $post_return;
    }

    function post_purchase_order($product,$supplier,$quantity,$price)
    {
        $URL = $this->base_url."purchaseOrders";

        $Payloud = build_purchase_order_payload($product,$supplier,$quantity,$price);
        echo $Payloud;

        $post_return = $this->HTTPPostRequest($URL,$Payloud);
        return $post_return;
    }
}

?>