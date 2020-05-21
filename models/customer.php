<?php

# customer model
class customer
{

    # variables the customer contains
    private $customer_id;
    private $customer_name;
    private $allocation; # the member of staff who manages the account
    private $address;
    private $town_city;
    private $post_code;
    private $phone;

    # create/instatiate the model for use
    function __construct($id,$name,$allocation,$address,$town_city,$post_code,$phone)
    {
        $this->customer_id = $id;
        $this->customer_name = $name;
        $this->allocation = $allocation;
        $this->address = $address;
        $this->town_city = $town_city;
        $this->post_code = $post_code;
        $this->phone = $phone;
    }

    # getters and setters
    function get_customer_id()
    {
        return $this->customer_id;
    }

    function set_customer_id($id)
    {
        $this->customer_id = $id;
    }

    function get_customer_name()
    {
        return $this->customer_name;
    }

    function set_customer_name($name)
    {
        $this->customer_name = $name;
    }

    function get_allocation()
    {
        return $this->allocation;
    }

    function set_allocation($allocation)
    {
        $this->allocation = $allocation;
    }

    function get_address()
    {
        return $this->address;
    }

    function set_address($address)
    {
        $this->address = $address;
    }

    function get_town_city()
    {
        return $this->town_city;
    }

    function set_town_city($town_city)
    {
        $this->town_city = $town_city;
    }

    function get_post_code()
    {
        return $this->post_code;
    }

    function set_post_code($post_code)
    {
        $this->post_code = $post_code;
    }

    function get_phone()
    {
        return $this->phone;
    }

    function set_phone($phone)
    {
        $this->phone = $phone;
    }
}

?>