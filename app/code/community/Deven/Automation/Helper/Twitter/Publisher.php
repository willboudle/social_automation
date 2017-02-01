<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 3/28/2016
 * Time: 2:29 PM
 */

class Deven_Automation_Helper_Twitter_Publisher extends Mage_Core_Helper_Abstract {

    public function generateTweet($product)
    {
        $percent = Mage::helper('deven_automation')->getTaxRate($product);

        $message = '';

        if(Mage::helper('deven_automation/twitter')->getMultipleProductPreText() != '' ) {
            $message .= Mage::helper('deven_automation/twitter')->getMultipleProductPreText() . ' ';
        }

        if(Mage::helper('deven_automation/twitter')->hasMultipleProductName()) {
            $message .= $product->getName();
        }

        if(Mage::helper('deven_automation/twitter')->hasMultipleProductSku()) {
            $message .= ' - SKU: ' . $product->getSku();
        }

        if(Mage::helper('deven_automation/twitter')->hasMultipleProductPrice()) {
            if(Mage::helper('deven_automation/twitter')->hasMultipleProductTax()) {
                $price = round($product->getPrice() + ($product->getPrice()*($percent/100)));
            } else {
                $price = $product->getPrice();
            }

            $message .= ' - Price: ' . Mage::helper('deven_automation')->getCurrencySymbol() . Mage::helper('deven_automation')->beautifyPrice($price);
        }

        if(Mage::helper('deven_automation/twitter')->hasMultipleProductUrl()) {
            $coreUrl = Mage::getModel('core/url_rewrite');
            $idPath = sprintf('product/%d', $product->getId());
            $coreUrl->loadByIdPath($idPath);

            $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB). $coreUrl->getRequestPath();

            $new_url = Mage::helper('deven_automation')->shortenUrl($url);
            $message .= ' '. $new_url;
        }

        /** 
        *add hash tag with band name
        */
        if (Mage::helper('deven_automation/twitter')->hasMultipleBandName() && $product->getData('bandname')) {
            $bandname = str_replace(array(" ", "'"), array("", ""), $product->getData('bandname'));
            $message .= '  #'.$bandname;
        }

        /** 
        * tag band in tweet 
        */
        if (Mage::helper('deven_automation/twitter')->hasMultipleBandName() && Mage::getModel('catalog/category')->loadByAttribute('band_sku', substr($product->getSku(), 0 , 3))) {
            $bandsku = substr($product->getSku(), 0 , 3);
            $category = Mage::getModel('catalog/category')->loadByAttribute('band_sku', $bandsku);
            $twitterhandle = $category->getData('band_twitter');
            $message .= '  @'.$twitterhandle;
        }

        return $message;
    }
} 