<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 3/28/2016
 * Time: 2:41 PM
 */

class Deven_Automation_Helper_Pinterest_Publisher extends Mage_Core_Helper_Abstract {

    public function generateMessage($product)
    {
        $percent = Mage::helper('deven_automation')->getTaxRate($product);

        $message = '';

        if(Mage::helper('deven_automation/pinterest')->getMultipleProductPreText() != '' ) {
            $message .= Mage::helper('deven_automation/pinterest')->getMultipleProductPreText() . ' ';
        }

        if(Mage::helper('deven_automation/pinterest')->hasMultipleProductName()) {
            $message .= Mage::helper('deven_automation')->stripTags($product->getName());
        }

        if(Mage::helper('deven_automation/pinterest')->hasMultipleProductShortDescription()) {
            $message .= ' - ' . Mage::helper('deven_automation')->stripTags($product->getShortDescription());
        }

        if(Mage::helper('deven_automation/pinterest')->hasMultipleProductSku()) {
            $message .= ' - SKU: ' . $product->getSku();
        }

        if(Mage::helper('deven_automation/pinterest')->hasMultipleProductPrice()) {
            if(Mage::helper('deven_automation/pinterest')->hasMultipleProductTax()) {
                $price = round($product->getPrice() + ($product->getPrice()*($percent/100)));
            } else {
                $price = $product->getPrice();
            }

            $message .= ' - Price: '. Mage::helper('deven_automation')->getCurrencySymbol() . Mage::helper('deven_automation')->beautifyPrice($price);
        }

        $coreUrl = Mage::getModel('core/url_rewrite');
        $idPath = sprintf('product/%d', $product->getId());
        $coreUrl->loadByIdPath($idPath);

        $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB, false). $coreUrl->getRequestPath();

        $message .= '. Buy now at '. $url;

        return $message;
    }
} 