<?php

namespace brevis;

 
class Registry
{

    private static $instance = null;

    /**
     *  Let's start session for writing down all the changes
     */
    private function __construct()
    {
        \session_start();
    }

    /**
     * Using pattern "singleton"
     */
    static function instance()
    {
        if(\is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function set($key, $value)
    {
        $_SESSION[__CLASS__][$key] = $value; 
    }

    private function get($key)
    {
        return $_SESSION[__CLASS__][$key];
    }

    public function getValue($key)
    {
        return $this->get( $key );
    }

    public function setValue($key,$value)
    {
        $this->set($key,$value);
       
    }

}