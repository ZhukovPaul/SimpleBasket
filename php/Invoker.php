<?php

namespace brevis;

/**
 * "Invoker" calls necessary command class
 */
class Invoker
{
    private $command = null; 
    
    function __construct( \brevis\Command\Command $command )
    {
       // if( \ReflectionClass::isInstantiable ($command) ){
            $this->command = $command;
       /* }else
            new Exception("Not exist");*/
    }


    public function execute( )
    {
        return $this->command->execute();
    } 
}