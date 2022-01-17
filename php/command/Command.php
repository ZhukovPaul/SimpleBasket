<?php

namespace brevis\Command;


abstract class Command
{
    public $args = [];
    
    function __construct($args)
    {
        $this->args = $args;
    }


    abstract public function execute(); 
}