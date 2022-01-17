<?php

namespace brevis\Command;
use \brevis;

class RemoveFromBasketCommand extends Command
{
    private $basket = null;

    function execute()
    {
        $instance = \brevis\Registry::instance();
        $this->basket = new \brevis\Basket( $instance );
        
        $this->basket->removeFromBasketById($this->args["id"]);

        return "Product was removed from basket";
    } 
}