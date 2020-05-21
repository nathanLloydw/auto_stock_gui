<?php

#product model
class product
{
    # variables the product contains
    private $product_id;
    private $product_name;
    private $product_stock;
    private $product_price;

    # create/instatiate the model for use
    function __construct($id,$name,$stock,$price)
    {
        $this->product_id = $id;
        $this->product_name = $name;
        $this->product_stock = $stock;
        $this->product_price = $price;
    }

    # getters and setters
    function get_id()
    {
        return $this->product_id;
    }

    function set_id($id)
    {
        $this->product_id = $id;
    }

    function get_name()
    {
        return $this->product_name;
    }

    function set_name($name)
    {
        $this->product_name = $name;
    }

    function get_stock()
    {
        return $this->product_stock;
    }

    function set_stock($stock)
    {
        $this->product_stock = $stock;
    }

    function get_price()
    {
        return $this->product_price;
    }

    function set_price($price)
    {
        $this->product_price = $price;
    }
}

?>