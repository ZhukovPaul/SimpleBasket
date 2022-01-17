<?php

namespace brevis;

/**
 * Class which emulate simple product basket
 */
class Basket
{
    private static $instance = null;


    /**
     * Constructor use Registry Object for recording into session
     * 
     * @param \brevis\Registry $instance
     */
    function __construct(  \brevis\Registry $instance  )
    {
        self::$instance = $instance;
    }

    public function getBasket()
    {
         
        return self::$instance->getValue("BASKET");
    }

    private function setBasket($arResult)
    {
        self::$instance->setValue("BASKET",$arResult);
    }

    public function addToBasket($array)
    {
        $fullArr = $this->getBasket();
        if(isset($fullArr[$array["ID"]])) {
            $array["COUNT"] = $fullArr[$array["ID"]]["COUNT"]+ $array["COUNT"];
        }
        $fullArr[$array["ID"]] = $array;
        $this->setBasket($fullArr);
    }
    
    public function removeFromBasketById($id)
    {
        $fullArr = $this->getBasket();
        unset($fullArr[$id]);
        self::$instance->setValue("BASKET", $fullArr);
    }

    public function setCountById($id,$count)
    {
        $fullArr = $this->getBasket();
        $fullArr[$id]["COUNT"] = $count;
        $this->setBasket($fullArr);
        
    }


    public function clearBasket()
    {
        $this->setBasket(Array());
        
    }



}