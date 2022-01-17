<?php

namespace brevis\Command;
use \brevis;

class AddToBasketCommand extends Command
{
    private $basket = null;

    function execute()
    {
        
        //print_r($this->args);

        $instance = \brevis\Registry::instance();
        $this->basket = new \brevis\Basket( $instance );
        
        $this->basket->addToBasket(["ID"=>$this->args["id"],"COUNT"=>$this->args["count"]]);

        return "Product was added into basket";
    } 
}