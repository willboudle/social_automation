<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/6/2015
 * Time: 5:06 PM
 */

class Deven_Automation_Helper_Facebook_Publisher extends Mage_Core_Helper_Abstract {

    public function generateMessage($product)
    {
        $percent = Mage::helper('deven_automation')->getTaxRate($product);

        $message = '';

        if(Mage::helper('deven_automation/facebook')->getMultipleProductPreText() != '' ) {
            $message .= Mage::helper('deven_automation/facebook')->getMultipleProductPreText() . ' ';
        }

        //
        if(mage::helper('deven_automation/facebook')->hasMultipleBandName() && $product->getData('bandname')) {
           if(strpos($product->getName(), $product->getData('bandname')) === false ) {
                $message .= $product->getData('bandname') . ' ';
           }
        }

        if(Mage::helper('deven_automation/facebook')->hasMultipleProductName()) {
            $message .= Mage::helper('deven_automation')->stripTags($product->getName());
        }

        if(Mage::helper('deven_automation/facebook')->hasMultipleProductShortDescription()) {
            $message .= ' - ' . Mage::helper('deven_automation')->stripTags($product->getShortDescription());
        }

        if(Mage::helper('deven_automation/facebook')->hasMultipleProductSku()) {
            $message .= Mage::helper('deven_automation')->__(' - SKU: ') . $product->getSku();
        }

        if(Mage::helper('deven_automation/facebook')->hasMultipleProductPrice()) {
            if(Mage::helper('deven_automation/facebook')->hasMultipleProductTax()) {
                $price = round($product->getPrice() + ($product->getPrice()*($percent/100)));
            } else {
                $price = $product->getPrice();
            }

            $message .= Mage::helper('deven_automation')->__(' - Price: '). Mage::helper('deven_automation')->getCurrencySymbol() . Mage::helper('deven_automation')->beautifyPrice($price);

        }

        if(Mage::helper('deven_automation/facebook')->hasMultipleProductUrl()) {

            $coreUrl = Mage::getModel('core/url_rewrite');
            $idPath = sprintf('product/%d', $product->getId());
            $coreUrl->loadByIdPath($idPath);

            $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB, false). $coreUrl->getRequestPath();

            if(Mage::helper('deven_automation/facebook')->hasMultipleProductShortenedUrl()) {
                $url = Mage::helper('deven_automation')->shortenUrl($url);
                $message .= Mage::helper('deven_automation')->__('. Buy now at '). $url;
            } else {
                $message .= Mage::helper('deven_automation')->__('. Buy now at '). $url;
            }
        }

        return $message;
    }
} 

