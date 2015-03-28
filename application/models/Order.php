<?php

class Order extends CI_Model 
{

    protected $xml = null;
    protected $burgers = array();
    protected $customer = null;
    protected $orderNo = null;
    protected $ordertype = null;
    // Constructor
    public function __construct() 
    {
        parent::__construct();
    }

    public function getOrderInfo($filename)
    {
        $this->xml = simplexml_load_file(DATAPATH . $filename);
        $customer = $this->xml->customer;
        $ordertype = $this->xml->attributes()->type;

        foreach( $this->xml->burger as $burger)
        {
            $burg = array();
            $burg["base"] = $burger->patty['type'];
            
            var_dump($burg);
        }
        
        /*
        foreach ($this->xml->burger as $burger) 
        {
            $burgerSpec = new stdClass();
            $burgerSpec->
        }*/
    }

}
