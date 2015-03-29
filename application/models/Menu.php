<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Menu extends CI_Model {

    protected $xml = null;
    protected $patty_names = array();
    protected $patties = array();
    protected $cheeses = array();
    protected $toppings = array();
    protected $sauces = array();

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    function buildMenu()
    {
        $this->xml = simplexml_load_file(DATAPATH . 'menu.xml');

        // build a full list of patties - approach 2
        foreach ($this->xml->patties->patty as $patty) 
        {
            $record = new stdClass();
            $record->code = (string) $patty['code'];
            $record->name = (string) $patty;
            $record->price = (float) $patty['price'];
            $this->patties[$record->code] = $record;
        }

        

        foreach($this->xml->cheeses->cheese as $cheese)
        {
            $record = new stdClass();
            $record->code = (string) $cheese['code'];
            $record->name = (string) $cheese;
            $record->price = (float) $cheese['price'];
            $this->cheeses[$record->code] = $record ;
        }

        foreach($this->xml->toppings->topping as $topping)
        {
            $record = new stdClass();
            $record->code = (string) $topping['code'];
            $record->name = (string) $topping;
            $record->price = (float) $topping['price'];
            $this->sauces[$record->code] = $record;
        }
        foreach($this->xml->sauces->sauce as $sauce)
        {
            $record = new stdClass();
            $record->code = (string) $sauce['code'];
            $record->name = (string) $sauce;
            $record->price = (float) $sauce['price'];
            $this->toppings[$record->code] = $record;
        }
    }

    // retrieve a list of patties, to populate a dropdown, for instance
    function patties() 
    {
        return $this->patty_names;
    }

    // retrieve a patty record, perhaps for pricing
    function getPatty($code) 
    {
        if (isset($this->patties[$code]))  
            return  $this->patties[$code]->price;
        else
            return null;
    }

    function getCheese($code)
    {
        if(isset($this->cheeses[$code]))
            return $this->cheeses[$code]->price;
        else
            return null;
    }

    function getSauce($code)
    {
        if(isset($this->sauces[$code]))
            return $this->sauces[$code]->price;
        else
            return null;
    }

    function getTopping($code)
    {
        if(isset($this->toppings[$code]))
            return $this->toppings[$code]->price;
        else
            return null;
    }

}
