<?php

#supplier model
class supplier
{
    # variables the supplier contains
    private $supplier_id;
    private $supplier_name;
    private $contact_name;
    private $contact_phone;
    private $contact_email;

    # create/instatiate the model for use
    function __construct($id,$supplier_name,$contact_name,$phone,$email)
    {
        $this->supplier_id = $id;
        $this->supplier_name = $supplier_name;
        $this->contact_name = $contact_name;
        $this->contact_phone = $phone;
        $this->contact_email = $email;
    }

    #getters and setters
    function get_supplier_id()
    {
        return $this->supplier_id;
    }

    function set_supplier_id($id)
    {
        $this->supplier_id = $id;
    }

    function get_supplier_name()
    {
        return $this->supplier_name;
    }

    function set_supplier_name($name)
    {
        $this->supplier_name = $name;
    }

    function get_contact_name()
    {
        return $this->contact_name;
    }

    function set_contact_name($name)
    {
        $this->contact_name = $name;
    }
    function get_contact_phone()
    {
        return $this->contact_phone;
    }

    function set_contact_phone($phone)
    {
        $this->contact_phone = $phone;
    }

    function get_contact_email()
    {
        return $this->contact_email;
    }

    function set_contact_email($email)
    {
        $this->contact_email = $email;
    }
}

?>