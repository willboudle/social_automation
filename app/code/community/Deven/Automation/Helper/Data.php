<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 3/28/2016
 * Time: 2:19 PM
 */

class Deven_Automation_Helper_Data extends Mage_Core_Helper_Abstract {

    public function beautifyPrice($price) {
        if(!isset($price))
            return 'unknown price';
        return number_format($price, 2, '.', ',');
    }

    /**
     * @param $product
     * @return mixed
     */
    public function getTaxRate($product)
    {
        $taxCalculation = Mage::getModel('tax/calculation');

        $taxClassId = $product->getTaxClassId();

        $request = $taxCalculation->getRateOriginRequest();

        $request->setProductClassId($taxClassId);

        $percent = $taxCalculation->getRate($request);

        return $percent;
    }

    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        return Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
    }

    public function shortenUrl($url) {
        $shortener = new Zend_Service_ShortUrl_TinyUrlCom;
        return $shortener->shorten($url);
    }
} 