<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
	   parent::__construct();
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

    function index()
    {
    	// Build a list of orders
    	
    	// Present the list to choose from
        
        $this->load->helper('directory');

        $map = directory_map(DATAPATH);

        $xml = '.xml';

        $new = array(); //Contains only xml files in directory

        $count = 0;
        //Loop through all file in directory
        foreach( $map as $m)
        {
            $count++;
            //If file ends in .xml put in $new array
            if (substr_compare($m, $xml, strlen($m)-strlen($xml), strlen($xml)) === 0
                && strcmp($m, 'menu.xml') != 0 )    
                { 
                    $x = array();
                    $x['filename'] = $m;
                    $x['ordertext']= 'order ' . $count;
                    array_push($new, $x);
                }
                else if (strcmp($m, 'menu.xml') == 0)
                {
                    $count--;
                }
        } 

        $this->data['order'] = $new;
    	$this->data['pagebody'] = 'homepage';
    	$this->render();
    }
    
    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

    function order($filename)
    {
    	// Build a receipt for the chosen order
        $this->load->model('order'); 
        $order = $this->order->getOrderInfo($filename);

        $this->data['ordernumber'] = $order['orderNo'];
        $this->data['name'] = $order['customer'];
        $this->data['ordertype'] = $order['orderType'];

        $this->data['burgers'] = $order['burgers'];
        // Present the list to choose from
    	$this->data['pagebody'] = 'justone';
    	$this->render();
    }
    

}
