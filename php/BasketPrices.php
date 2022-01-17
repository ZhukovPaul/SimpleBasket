<?php

namespace brevis;

class BasketPrices
{
    private static $basketInstance = null;
    private static $iblockId = null;

    /*
     *  Функция возвращает список всех товаров в корзине и их стоимость 
     * 
     *  $basket brevis\Basket - обект корзины 
     *  $iblockId integer - Id инфоблока с товарами
     * 
     */   

    function __construct($basket = "" , $iblockId = "")
    {
        if($basket=="" || $iblockId=="") throw new \Exception('Not found parameters');
        
        if(is_null(self::$basketInstance))
            self::$basketInstance = $basket;
        if(is_null(self::$iblockId))
            self::$iblockId = $iblockId;
    }

    /*
     *  Функция возвращает список всех товаров в корзине и их стоимость 
     * 
     *  $pricePropCode string - код свойства "Цена"
     *  $discountPropCode string - код свойства "Цена со скидкой"
     */   
    function getBasketPriceList($pricePropCode,$discountPropCode)
    {
        \CModule::IncludeModule("iblock");

        $basketArray = self::$basketInstance->getBasket(); 
        $elKeys = array_keys($basketArray);

        $arFilter = Array(
                "ID"        =>  $elKeys,
                "IBLOCK_ID" =>  self::$iblockId
            );
        $arProps = Array(
                "ID","NAME","IBLOCK_ID","DETAIL_PAGE_URL","CODE","PROPERTY_{$pricePropCode}","PROPERTY_{$discountPropCode}"
            );
        $BCIBElements = \CIBlockElement::GetList(
            Array(),
            $arFilter,
            false,
            false,
            $arProps
           );
        
        $arResult = Array();
    
        while($productElement = $BCIBElements->GetNext()){
            $arResult[] = $productElement;
        }

        return $arResult;
        
    }


    /*
     *  Функция возвращает стоимость всех товаров в корзине
     * 
     *  $pricePropCode string - код свойства "Цена"
     *  $discountPropCode string - код свойства "Цена со скидкой"
     */

    function getBasketPrice($pricePropCode,$discountPropCode)
    {
        $basketArray = self::$basketInstance->getBasket(); 

        $summPrice = 0 ;
        $elementsArr = $this->getBasketPriceList($pricePropCode,$discountPropCode);
        
        if(count($elementsArr) == 0) return 0;
        
        foreach($elementsArr as $element){

            if( $element["PROPERTY_{$discountPropCode}_VALUE"] != "" )
                $price =  $element["PROPERTY_{$discountPropCode}_VALUE"];
            else 
                $price =  $element["PROPERTY_{$pricePropCode}_VALUE"];
            
            $summPrice =  $summPrice + ($price* $basketArray[$element["ID"]]["COUNT"] ); 

        }
        return $summPrice;
    }
}