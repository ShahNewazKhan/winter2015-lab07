<?php

class Order extends CI_Model 
{

    protected $xml = null; 

    // Constructor
    public function __construct() 
    {
        parent::__construct();    
    }

    public function getOrderInfo($filename)
    {
        $burgers = array();
        $order = array();

        $this->load->model('menu');
        $this->menu->buildMenu();

        $order['orderNo'] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
        $this->xml = simplexml_load_file(DATAPATH . $filename);
        $order['customer'] = $this->xml->customer;
        $order['orderType'] = $this->xml->attributes()->type;

        foreach( $this->xml->burger as $burger)
        {
            $burg = array();
            $burg["cheeses"] = " ";
            $burg["sauces"] = " ";
            $burg["toppings"] = " ";
            $sauces = array();
            $toppings = array();
            
            $total = 0.0;

            $burg["patty"] = (string)$burger->patty['type'];
            $total = $this->menu->getPatty($burg["patty"]);

            if($burger->cheeses['top'])
            {
                if($burg["cheeses"])
                {
                    $burg["cheeses"] = $burg["cheeses"]."  ".(string)$burger->cheeses['top'];
                }
                else
                {
                    $burg["cheeses"] = (string)$burger->cheeses['top'];
                }
            }
            
            if($burger->cheeses['bottom'])
            {
                if($burg["cheeses"])
                {
                    $burg["cheeses"] = $burg["cheeses"]."  ".(string)$burger->cheeses['bottom'];
                }
                else
                {
                    $burg["cheeses"] = (string)$burger->cheeses['bottom'];
                }
            }   
            
            foreach($burger->sauce as $sauce)
            {
                if($burg["sauces"])
                {
                    $burg["sauces"] = $burg["sauces"] . " " .(string)$sauce['type'];
                }
                else
                {
                    $burg["sauces"] = (string)$sauce['type'];
                }
                
            }

            foreach($burger->topping as $topping)
            {
                if($burg["toppings"])
                {
                    $burg["toppings"] = $burg["toppings"] . " " .(string)$topping['type'];
                }
                else
                {
                    $burg["toppings"] = (string)$topping['type'];
                }
            }

            if($burger->instructions)
                $burg["instructions"] = (string)$burger->instructions;

            array_push($burgers, $burg);
        }
        
        $order['burgers'] = $burgers;
        
        return $order;
    }

}
