<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 3/28/2016
 * Time: 2:34 PM
 */

class Deven_Automation_Helper_Pinterest extends Mage_Core_Helper_Abstract {

    const  XML_PATH_LIMITED_NUMBER = 'automation/pinterest/limited_number';

    const XML_PATH_AUTOPIN_NEW_PRODUCT = 'automation/pinterest/autopin_new_product';
    const XML_PATH_AUTOPIN_NEW_PRODUCT_TYPE = 'automation/pinterest/new_product_type';
    const XML_PATH_AUTOPIN_NEW_PRODUCT_BOARD = 'automation/pinterest/new_product_boards';
    const XML_PATH_AUTOPIN_NEW_PRODUCT_VISIBILITY = 'automation/pinterest/new_product_visibility';
    const XML_PATH_AUTOPIN_NEW_PRODUCT_DISPLAY_PRODUCT_NAME = 'automation/pinterest/new_product_display_product_name';
    const XML_PATH_AUTOPIN_NEW_PRODUCT_DISPLAY_SHORT_DESCRIPTION = 'automation/pinterest/new_product_display_short_description';
    const XML_PATH_AUTOPIN_NEW_PRODUCT_DISPLAY_SKU = 'automation/pinterest/new_product_display_sku';
    const XML_PATH_AUTOPIN_NEW_PRODUCT_DISPLAY_PRICE = 'automation/pinterest/new_product_display_price';
    const XML_PATH_AUTOPIN_NEW_PRODUCT_TAX = 'automation/pinterest/new_product_tax';
    const XML_PATH_AUTOPIN_NEW_PRODUCT_PRE_TEXT = 'automation/pinterest/new_product_pre_text';

    const XML_PATH_MULTIPLE_PRODUCT = 'automation/pinterest/pin_multiple_product_on_pinterest';
    const XML_PATH_MULTIPLE_PRODUCT_TYPE = 'automation/pinterest/multiple_product_type';
    const XML_PATH_MULTIPLE_PRODUCT_VISIBILITY = 'automation/pinterest/multiple_product_visibility';
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_PRODUCT_NAME = 'automation/pinterest/multiple_product_display_product_name';
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_SHORT_DESCRIPTION = 'automation/pinterest/multiple_product_display_short_description';
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_SKU = 'automation/pinterest/multiple_product_display_sku';
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_PRICE = 'automation/pinterest/multiple_product_display_price';
    const XML_PATH_MULTIPLE_PRODUCT_TAX = 'automation/pinterest/multiple_product_tax';
    const XML_PATH_MULTIPLE_PRODUCT_PRE_TEXT = 'automation/pinterest/multiple_product_pre_text';

    const XML_PATH_AUTO_PIN_RANDOMLY_PRODUCT = 'automation/pinterest/enabled_autopin_randomly_product';

    protected function _getStoreConfig($xmlPath)
    {
        return Mage::getStoreConfig($xmlPath, Mage::app()->getStore()->getId());
    }

    /* Pin New Product Config */

    public function isEnabledNewProduct() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPIN_NEW_PRODUCT);
    }

    public function getEnableNewProductType() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPIN_NEW_PRODUCT_TYPE);
    }

    public function getEnableNewProductBoards() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPIN_NEW_PRODUCT_BOARD);
    }

    public function getEnableNewProductVisibility() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPIN_NEW_PRODUCT_VISIBILITY);
    }

    public function hasNewProductName() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPIN_NEW_PRODUCT_DISPLAY_PRODUCT_NAME);
    }

    public function hasNewProductShortDescription() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPIN_NEW_PRODUCT_DISPLAY_SHORT_DESCRIPTION);
    }

    public function hasNewProductSku() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPIN_NEW_PRODUCT_DISPLAY_SKU);
    }

    public function hasNewProductPrice() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPIN_NEW_PRODUCT_DISPLAY_PRICE);
    }

    public function hasNewProductTax() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPIN_NEW_PRODUCT_TAX);
    }

    public function getNewProductPreText() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPIN_NEW_PRODUCT_PRE_TEXT);
    }

    /* Pin Multiple Product Config*/

    public function isEnabledMultipleProduct() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT);
    }

    public function getEnableMultipleProductType() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_TYPE);
    }

    public function getEnableMultipleProductVisibility() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_VISIBILITY);
    }

    public function hasMultipleProductName() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_DISPLAY_PRODUCT_NAME);
    }

    public function hasMultipleProductShortDescription() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_DISPLAY_SHORT_DESCRIPTION);
    }

    public function hasMultipleProductSku() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_DISPLAY_SKU);
    }

    public function hasMultipleProductPrice() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_DISPLAY_PRICE);
    }

    public function hasMultipleProductTax() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_TAX);
    }

    public function getMultipleProductPreText() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_PRE_TEXT);
    }

    public function getLimitedNumber() {
        return $this->_getStoreConfig(self::XML_PATH_LIMITED_NUMBER);
    }

    /* Auto pin Randomly Product Config */

    public function isEnabledAutopinRandomlyProduct() {
        return $this->_getStoreConfig(self::XML_PATH_AUTO_PIN_RANDOMLY_PRODUCT);
    }
} 