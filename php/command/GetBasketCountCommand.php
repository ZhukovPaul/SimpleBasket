<?php

namespace brevis\Command;
use \brevis;

class GetBasketCountCommand extends Command
{
    private $basket = null;

    function execute()
    {
        $this->basket = new \brevis\Basket( \brevis\Registry::instance() );
        
        $count = count($this->basket->getBasket());

        return $count;
    } 
}