<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 3/27/2016
 * Time: 2:46 PM
 */

class Deven_Automation_Helper_Facebook extends Mage_Core_Helper_Abstract {

    const  XML_PATH_POST_ON_PAGE = 'automation/facebook/post_on_page';
    const  XML_PATH_POST_ON_BOTH = 'automation/facebook/post_on_both';
    const  XML_PATH_LIMITED_NUMBER = 'automation/facebook/limited_number';

    const XML_PATH_AUTOPOST_NEW_PRODUCT = 'automation/facebook/autopost_new_product';
    const XML_PATH_AUTOPOST_NEW_PRODUCT_ON_ALL_GROUPS = 'automation/facebook/autopost_new_product_on_all_groups';
    const XML_PATH_AUTOPOST_NEW_PRODUCT_TYPE = 'automation/facebook/new_product_type';
    const XML_PATH_AUTOPOST_NEW_PRODUCT_VISIBILITY = 'automation/facebook/new_product_visibility';
    const XML_PATH_AUTOPOST_NEW_PRODUCT_DISPLAY_PRODUCT_NAME = 'automation/facebook/new_product_display_product_name';
    const XML_PATH_AUTOPOST_NEW_PRODUCT_DISPLAY_SHORT_DESCRIPTION = 'automation/facebook/new_product_display_short_description';
    const XML_PATH_AUTOPOST_NEW_PRODUCT_DISPLAY_SKU = 'automation/facebook/new_product_display_sku';
    const XML_PATH_AUTOPOST_NEW_PRODUCT_DISPLAY_PRICE = 'automation/facebook/new_product_display_price';
    const XML_PATH_AUTOPOST_NEW_PRODUCT_TAX = 'automation/facebook/new_product_tax';
    const XML_PATH_AUTOPOST_NEW_PRODUCT_DISPLAY_URL = 'automation/facebook/new_product_display_url';
    const XML_PATH_AUTOPOST_NEW_PRODUCT_SHORTEN_URL = 'automation/facebook/new_product_shorten_url';
    const XML_PATH_AUTOPOST_NEW_PRODUCT_UPLOAD_IMAGE = 'automation/facebook/new_product_upload_image';
    const XML_PATH_AUTOPOST_NEW_PRODUCT_PRE_TEXT = 'automation/facebook/new_product_pre_text';

    const XML_PATH_MULTIPLE_PRODUCT = 'automation/facebook/update_multiple_product_on_facebook';
    const XML_PATH_MULTIPLE_PRODUCT_ON_ALL_GROUPS = 'automation/facebook/update_multiple_product_on_all_groups';
    const XML_PATH_MULTIPLE_PRODUCT_TYPE = 'automation/facebook/multiple_product_type';
    const XML_PATH_MULTIPLE_PRODUCT_VISIBILITY = 'automation/facebook/multiple_product_visibility';
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_PRODUCT_NAME = 'automation/facebook/multiple_product_display_product_name';
    //
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_BAND_NAME = 'automation/facebook/multiple_product_display_band_name';
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_SHORT_DESCRIPTION = 'automation/facebook/multiple_product_display_short_description';
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_SKU = 'automation/facebook/multiple_product_display_sku';
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_PRICE = 'automation/facebook/multiple_product_display_price';
    const XML_PATH_MULTIPLE_PRODUCT_TAX = 'automation/facebook/multiple_product_tax';
    const XML_PATH_MULTIPLE_PRODUCT_DISPLAY_URL = 'automation/facebook/multiple_product_display_url';
    const XML_PATH_MULTIPLE_PRODUCT_SHORTEN_URL = 'automation/facebook/multiple_product_shorten_url';
    const XML_PATH_MULTIPLE_PRODUCT_UPLOAD_IMAGE = 'automation/facebook/multiple_product_upload_image';
    const XML_PATH_MULTIPLE_PRODUCT_PRE_TEXT = 'automation/facebook/multiple_product_pre_text';
    

    const XML_PATH_POST_MULTIPLE_ARTICLES_ON_FACEBOOK = 'automation/facebook/post_multiple_articles_on_facebook';
    const XML_PATH_POST_MULTIPLE_ARTICLES_ON_ALL_GROUPS = 'automation/facebook/post_multiple_articles_on_all_groups';
    const XML_PATH_POST_MULTIPLE_ARTICLES_LIMITED_NUMBER = 'automation/facebook/limited_number_articles';
    const XML_PATH_JUST_POST_MULTIPLE_ARTICLES_TITLE_AND_CONTENT = 'automation/facebook/just_post_multiple_articles_title_and_content';
    const XML_PATH_POST_MULTIPLE_ARTICLES_TITLE = 'automation/facebook/post_multiple_articles_title';
    const XML_PATH_POST_MULTIPLE_ARTICLES_SHORT_DESCRIPTION = 'automation/facebook/post_multiple_articles_short_description';
    const XML_PATH_POST_MULTIPLE_ARTICLES_DISPLAY_URL = 'automation/facebook/post_multiple_articles_display_url';
    const XML_PATH_POST_MULTIPLE_ARTICLES_SHORTEN_URL = 'automation/facebook/post_multiple_articles_shorten_url';

    const XML_PATH_AUTOPOST_RANDOMLY_PRODUCT = 'automation/facebook/enabled_autopost_randomly_product';

    protected function _getStoreConfig($xmlPath)
    {
        return Mage::getStoreConfig($xmlPath, Mage::app()->getStore()->getId());
    }

    /*Post on Page config*/

    public function isEnabledPostOnPage() {
        return $this->_getStoreConfig(self::XML_PATH_POST_ON_PAGE);
    }

    public function isEnabledPostOnBoth() {
        return $this->_getStoreConfig(self::XML_PATH_POST_ON_BOTH);
    }

    /* Post New Product Config */

    public function isEnabledNewProduct() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT);
    }

    public function isEnabledPostNewProductOnAllGroups() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT_ON_ALL_GROUPS);
    }

    public function getEnableNewProductType() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT_TYPE);
    }

    public function getEnableNewProductVisibility() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT_VISIBILITY);
    }

    public function hasNewProductName() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT_DISPLAY_PRODUCT_NAME);
    }

    public function hasNewProductShortDescription() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT_DISPLAY_SHORT_DESCRIPTION);
    }

    public function hasNewProductSku() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT_DISPLAY_SKU);
    }

    public function hasNewProductPrice() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT_DISPLAY_PRICE);
    }

    public function hasNewProductTax() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT_TAX);
    }

    public function hasNewProductUrl() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT_DISPLAY_URL);
    }

    public function hasNewProductShortenedUrl() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT_SHORTEN_URL);
    }

    public function hasNewProductUploadImage() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT_UPLOAD_IMAGE);
    }

    public function getNewProductPreText() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_NEW_PRODUCT_PRE_TEXT);
    }

    /* Post Multiple Product Config*/

    public function isEnabledMultipleProduct() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT);
    }

    public function isEnabledPostMultipleProductOnAllGroups() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_ON_ALL_GROUPS);
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

    //
    public function hasMultipleBandName() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_DISPLAY_BAND_NAME);
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

    public function hasMultipleProductUrl() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_DISPLAY_URL);
    }

    public function hasMultipleProductShortenedUrl() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_SHORTEN_URL);
    }

    public function hasMultipleProductUploadImage() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_UPLOAD_IMAGE);
    }

    public function getMultipleProductPreText() {
        return $this->_getStoreConfig(self::XML_PATH_MULTIPLE_PRODUCT_PRE_TEXT);
    }

    public function getLimitedNumber() {
        return $this->_getStoreConfig(self::XML_PATH_LIMITED_NUMBER);
    }

    /* Post Multiple Articles Config */

    public function isEnabledPostMultipleArticles() {
        return $this->_getStoreConfig(self::XML_PATH_POST_MULTIPLE_ARTICLES_ON_FACEBOOK);
    }

    public function isEnabledPostMultipleArticlesOnAllGroups() {
        return $this->_getStoreConfig(self::XML_PATH_POST_MULTIPLE_ARTICLES_ON_ALL_GROUPS);
    }

    public function getArticlesLimitedNumber() {
        return $this->_getStoreConfig(self::XML_PATH_POST_MULTIPLE_ARTICLES_LIMITED_NUMBER);
    }

    public function isJustPostMultipleArticlesTitleAndContent() {
        return $this->_getStoreConfig(self::XML_PATH_JUST_POST_MULTIPLE_ARTICLES_TITLE_AND_CONTENT);
    }

    public function hasPostMultipleArticlesTitle() {
        return $this->_getStoreConfig(self::XML_PATH_POST_MULTIPLE_ARTICLES_TITLE);
    }

    public function hasPostMultipleArtilesShortDescription() {
        return $this->_getStoreConfig(self::XML_PATH_POST_MULTIPLE_ARTICLES_SHORT_DESCRIPTION);
    }

    public function hasPostMultipleArticlesDisplayUrl() {
        return $this->_getStoreConfig(self::XML_PATH_POST_MULTIPLE_ARTICLES_DISPLAY_URL);
    }

    public function isPostMultipleArticlesShortenUrl() {
        return $this->_getStoreConfig(self::XML_PATH_POST_MULTIPLE_ARTICLES_SHORTEN_URL);
    }

    /* Auto Post Randomly Product Config */

    public function isEnabledAutoPostRandomlyProduct() {
        return $this->_getStoreConfig(self::XML_PATH_AUTOPOST_RANDOMLY_PRODUCT);
    }

} 