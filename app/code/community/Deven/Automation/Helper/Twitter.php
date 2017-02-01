<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 3/27/2016
 * Time: 4:12 PM
 */

class Deven_Automation_Helper_Twitter extends Mage_Core_Helper_Abstract {

    const XML_PATH_AUTOTWEET_NEW_PRODUCT = 'automation/twitter/autotweet_new_product';
    const XML_PATH_AUTOTWEET_NEW_PRODUCT_TYPE = 'automation/twitter/new_product_type';
    const XML_PATH_AUTOTWEET_NEW_PRODUCT_VISIBILITY = 'automation/twitter/new_product_visibility';
    const XML_PATH_AUTOTWEET_NEW_PRODUCT_DISPLAY_PRODUCT_NAME = 'automation/twitter/new_product_display_product_name';
    const XML_PATH_AUTOTWEET_NEW_PRODUCT_DISPLAY_SKU = 'automation/twitter/new_product_display_sku';
    const XML_PATH_AUTOTWEET_NEW_PRODUCT_DISPLAY_PRICE = 'automation/twitter/new_product_display_price';
    const XML_PATH_AUTOTWEET_NEW_PRODUCT_TAX = 'automation/twitter/new_product_tax';
    const XML_PATH_AUTOTWEET_NEW_PRODUCT_CURRENCY_SIGN = 'automation/twitter/new_product_currency_sign';
    const XML_PATH_AUTOTWEET_NEW_PRODUCT_DISPLAY_URL = 'automation/twitter/new_product_display_url';
    const XML_PATH_AUTOTWEET_NEW_PRODUCT_UPLOAD_IMAGE = 'automation/twitter/new_product_upload_image';
    const XML_PATH_AUTOTWEET_NEW_PRODUCT_PRE_TEXT = 'automation/twitter/new_product_pre_text';

    const XML_PATH_MULTIPLE_PRODUCT = 'automation/twitter/update_multiple_product_on_twitter';
    const XML_PATH_MULTIPLE_PRODUCT_TYPE = 'automation/twitter/multiple_product_type';
    const XML_PATH_MULTIPLE_PRODUCT_VISIBILITY = 'automation/twitter/multiple_product_visibility';
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_PRODUCT_NAME = 'automation/twitter/multiple_product_display_product_name';
    // added
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_BAND_NAME = 'automation/twitter/multiple_product_display_band_name';

    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_SKU = 'automation/twitter/multiple_product_display_sku';
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_PRICE = 'automation/twitter/multiple_product_display_price';
    const XML_PATH_MULTIPLE_PRODUCT_TAX = 'automation/twitter/multiple_product_tax';
    const XML_PATH_MULTIPLE_PRODUCT_CURRENCY_SIGN = 'automation/twitter/multiple_product_currency_sign';
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_URL = 'automation/twitter/multiple_product_display_url';
    const XML_PATH_MULTIPLE_PRODUCT_UPLOAD_IMAGE = 'automation/twitter/multiple_product_upload_image';
    const XML_PATH_MULTIPLE_PRODUCT_PRE_TEXT = 'automation/twitter/multiple_product_pre_text';

    const XML_PATH_AUTOTWEET_RANDOMLY_PRODUCT = 'automation/twitter/enabled_autotweet_randomly_product';

    protected function _getStoreConfig($xmlPath)
    {
        return Mage::getStoreConfig($xmlPath, Mage::app()->getStore()->getId());
    }

    public function isEnabledNewProduct() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOTWEET_NEW_PRODUCT);
    }

    public function getEnableNewProductType() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOTWEET_NEW_PRODUCT_TYPE);
    }

    public function getEnableNewProductVisibility() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOTWEET_NEW_PRODUCT_VISIBILITY);
    }

    public function hasNewProductName() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOTWEET_NEW_PRODUCT_DISPLAY_PRODUCT_NAME);
    }

    public function hasNewProductSku() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOTWEET_NEW_PRODUCT_DISPLAY_SKU);
    }

    public function hasNewProductPrice() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOTWEET_NEW_PRODUCT_DISPLAY_PRICE);
    }

    public function hasNewProductTax() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOTWEET_NEW_PRODUCT_TAX);
    }

    public function getNewProductCurrencySign() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOTWEET_NEW_PRODUCT_CURRENCY_SIGN);
    }

    public function hasNewProductUrl() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOTWEET_NEW_PRODUCT_DISPLAY_URL);
    }

    public function hasNewProductUploadImage() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOTWEET_NEW_PRODUCT_UPLOAD_IMAGE);
    }

    public function getNewProductPreText() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOTWEET_NEW_PRODUCT_PRE_TEXT);
    }

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

    //added
    public function hasMultipleBandName() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_DISPLAY_BAND_NAME);
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

    public function getMultipleProductCurrencySign() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_CURRENCY_SIGN);
    }

    public function hasMultipleProductUrl() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_DISPLAY_URL);
    }

    public function hasMultipleProductUploadImage() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_UPLOAD_IMAGE);
    }

    public function getMultipleProductPreText() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_PRE_TEXT);
    }

    /* Auto Tweet Randomly Product Config */

    public function isEnabledAutotweetRandomlyProduct() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOTWEET_RANDOMLY_PRODUCT);
    }
} 