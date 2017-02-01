<?php
require_once("Mage/Adminhtml/controllers/Catalog/ProductController.php");
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 3/27/2016
 * Time: 2:42 PM
 */

class Deven_Automation_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController {

    public function massPostAction()
    {
        $productIds = $this->getRequest()->getParam('product');

        if (!is_array($productIds)) {
            $this->_getSession()->addError($this->__('Please select product(s).'));
        } else {

            if(count($productIds) <= Mage::helper('deven_automation/facebook')->getLimitedNumber()) {
                try {
                    $types = explode(',', Mage::helper('deven_automation/facebook')->getEnableMultipleProductType());

                    if(Mage::helper('deven_automation/facebook')->isEnabledMultipleProduct()) {

                        $count = 0;

                        foreach ($productIds as $productId) {
                            $product = Mage::getSingleton('catalog/product')->load($productId);

                            if($product->getVisibility() == Mage::helper('deven_automation/facebook')->getEnableMultipleProductVisibility()
                                && in_array($product->getTypeId(), $types)
                                && $product->getStatus() == 1) {

                                $count++;

                                $message = Mage::helper('deven_automation/facebook_publisher')->generateMessage($product);

                                $coreUrl = Mage::getModel('core/url_rewrite');
                                $idPath = sprintf('product/%d', $product->getId());
                                $coreUrl->loadByIdPath($idPath);

                                $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB, false). $coreUrl->getRequestPath();

                                $image = Mage::helper('catalog/image')->init($product, 'image');

                                if(Mage::helper('deven_automation/facebook')->hasMultipleProductUploadImage()) {

                                    if($product->getImage() == 'no_selection') {

                                        if(Mage::helper('deven_automation/facebook')->isEnabledPostMultipleProductOnAllGroups()) {
                                            Mage::getModel('deven_automation/facebook_product_publisher')
                                                ->postOnGroups($message,
                                                    $url, $image->__toString(),
                                                    $product->getName(),
                                                    $product->getShortDescription());
                                        }

                                        if(Mage::helper('deven_automation/facebook')->isEnabledPostOnPage()) {
                                            Mage::getModel('deven_automation/facebook_product_publisher')
                                                ->postOnPages($message,
                                                    $url, $image->__toString(),
                                                    $product->getName(),
                                                    $product->getShortDescription());

                                            if(Mage::helper('deven_automation/facebook')->isEnabledPostOnBoth()) {
                                                Mage::getModel('deven_automation/facebook_product_publisher')
                                                    ->postOnProfile($message,
                                                        $url, $image->__toString(),
                                                        $product->getName(),
                                                        $product->getShortDescription());
                                            }
                                        } else {
                                            Mage::getModel('deven_automation/facebook_product_publisher')
                                                ->postOnProfile($message,
                                                    $url, $image->__toString(),
                                                    $product->getName(),
                                                    $product->getShortDescription());
                                        }
                                    } else {

                                        if($image) {
                                            if(Mage::helper('deven_automation/facebook')->isEnabledPostMultipleProductOnAllGroups()) {
                                                Mage::getModel('deven_automation/facebook_product_publisher')
                                                    ->postPhotoOnGroups($message, $image->__toString());
                                            }

                                            if(Mage::helper('deven_automation/facebook')->isEnabledPostOnPage()) {
                                                Mage::getModel('deven_automation/facebook_product_publisher')
                                                    ->postPhotoOnPages($message, $image->__toString());
                                                if(Mage::helper('deven_automation/facebook')->isEnabledPostOnBoth()) {
                                                    Mage::getModel('deven_automation/facebook_product_publisher')
                                                        ->postPhotoOnProfile($message, $image->__toString());
                                                }
                                            } else {
                                                Mage::getModel('deven_automation/facebook_product_publisher')
                                                    ->postPhotoOnProfile($message, $image->__toString());
                                            }
                                        }
                                    }

                                } else {
                                    if(Mage::helper('deven_automation/facebook')->isEnabledPostMultipleProductOnAllGroups()) {
                                        Mage::getModel('deven_automation/facebook_product_publisher')
                                            ->postOnGroups($message,
                                                $url, $image,
                                                $product->getName(),
                                                $product->getShortDescription());
                                    }

                                    if(Mage::helper('deven_automation/facebook')->isEnabledPostOnPage()) {
                                        Mage::getModel('deven_automation/facebook_product_publisher')
                                            ->postOnPages($message,
                                                $url, $image->__toString(),
                                                $product->getName(),
                                                $product->getShortDescription());
                                        if(Mage::helper('deven_automation/facebook')->isEnabledPostOnBoth()) {
                                            Mage::getModel('deven_automation/facebook_product_publisher')
                                                ->postOnProfile($message,
                                                    $url, $image->__toString(),
                                                    $product->getName(),
                                                    $product->getShortDescription());
                                        }
                                    } else {
                                        Mage::getModel('deven_automation/facebook_product_publisher')
                                            ->postOnProfile($message,
                                                $url, $image->__toString(),
                                                $product->getName(),
                                                $product->getShortDescription());
                                    }
                                }
                            }

                        }
                        $this->_getSession()->addSuccess(
                            $this->__('Total of %d product(s) have been posted on Facebook.', $count)
                        );
                    }

                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            } else {
                $this->_getSession()->addError(
                    $this->__('Please don\'t post over '. Mage::helper('deven_automation/facebook')->getLimitedNumber() .' products!')
                );
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massPinAction()
    {
        $productIds = $this->getRequest()->getParam('product');
        $boards = $this->getRequest()->getParam('boards');

        if (!is_array($productIds)) {
            $this->_getSession()->addError($this->__('Please select product(s).'));
        } else {

            if(count($productIds) <= Mage::helper('deven_automation/pinterest')->getLimitedNumber()) {
                try {
                    $types = explode(',', Mage::helper('deven_automation/pinterest')->getEnableMultipleProductType());

                    if(Mage::helper('deven_automation/pinterest')->isEnabledMultipleProduct()) {

                        $count = 0;

                        foreach ($productIds as $productId) {
                            $product = Mage::getSingleton('catalog/product')->load($productId);

                            if($product->getVisibility() == Mage::helper('deven_automation/pinterest')->getEnableMultipleProductVisibility()
                                && in_array($product->getTypeId(), $types)
                                && $product->getStatus() == 1) {

                                $count++;

                                $message = Mage::helper('deven_automation/pinterest_publisher')->generateMessage($product);

                                $coreUrl = Mage::getModel('core/url_rewrite');
                                $idPath = sprintf('product/%d', $product->getId());
                                $coreUrl->loadByIdPath($idPath);

                                $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB, false). $coreUrl->getRequestPath();

                                $image = Mage::helper('catalog/image')->init($product, 'image');

                                Mage::getModel('deven_automation/pinterest_pin_publisher')->pinOnBoards($boards, $message, $url, $image->__toString());
                            }

                        }
                        $this->_getSession()->addSuccess(
                            $this->__('Total of %d product(s) have been pinned on Pinterest.', $count)
                        );
                    }

                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            } else {
                $this->_getSession()->addError(
                    $this->__('Please don\'t pin over '. Mage::helper('deven_automation/pinterest')->getLimitedNumber() .' products!')
                );
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massTweetAction()
    {
        $productIds = $this->getRequest()->getParam('product');
        if (!is_array($productIds)) {
            $this->_getSession()->addError($this->__('Please select product(s).'));
        } else {
            if (!empty($productIds)) {
                if(count($productIds) <= 100) {
                    try {
                        $count = 0;

                        $types = explode(',', Mage::helper('deven_automation/twitter')->getEnableMultipleProductType());

                        foreach ($productIds as $productId) {
                            $product = Mage::getSingleton('catalog/product')->load($productId);

                            if($product->getVisibility() == Mage::helper('deven_automation/twitter')->getEnableMultipleProductVisibility()
                                && in_array($product->getTypeId(), $types)
                                && $product->getStatus() == 1) {

                                $count++;

                                $client = Mage::getModel('deven_automation/twitter_client');

                                $message = Mage::helper('deven_automation/twitter_publisher')->generateTweet($product);

                                if(Mage::helper('deven_automation/twitter')->isEnabledMultipleProduct()) {

                                    if(Mage::helper('deven_automation/twitter')->hasMultipleProductUploadImage()) {

                                        if($product->getImage() == 'no_selection') {
                                            $response = $client->api('/statuses/update.json', 'POST', array('status' => $message));
                                        } else {
                                            $image = Mage::helper('catalog/image')->init($product, 'image');

                                            if($image) {
                                                $response = $client->api('/statuses/update_with_media.json', 'POST', array('status' => $message), true, $image->__toString(), 'media[]');
                                            }
                                        }

                                    } else {
                                        $response = $client->api('/statuses/update.json', 'POST', array('status' => $message));
                                    }

                                }
                            }

                        }
                        $this->_getSession()->addSuccess(
                            $this->__('Total of %d product(s) have been updated on Twitter.', $count)
                        );
                    } catch (Exception $e) {
                        $this->_getSession()->addError($e->getMessage());
                    }
                } else {
                    $this->_getSession()->addError(
                        $this->__('Please don\'t updated over 100 products!')
                    );
                }
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massScheduledPostAction() {

        $productIds = $this->getRequest()->getParam('product');
        $timezone = Mage::app()->getStore()->getConfig(Mage_Core_Model_Locale::XML_PATH_DEFAULT_TIMEZONE);

        $time = new Zend_Date($this->getRequest()->getParam('post_time'), null, Mage::getModel('core/locale')->getLocale());
        $time->setTimezone($timezone);

        if (!is_array($productIds)) {
            $this->_getSession()->addError($this->__('Please select product(s).'));
        } else {

            if(count($productIds) <= Mage::helper('deven_automation/facebook')->getLimitedNumber()) {
                try {
                    $types = explode(',', Mage::helper('deven_automation/facebook')->getEnableMultipleProductType());

                    if(Mage::helper('deven_automation/facebook')->isEnabledMultipleProduct()) {

                        $count = 0;

                        foreach ($productIds as $productId) {
                            $product = Mage::getSingleton('catalog/product')->load($productId);

                            if($product->getVisibility() == Mage::helper('deven_automation/facebook')->getEnableMultipleProductVisibility()
                                && in_array($product->getTypeId(), $types)
                                && $product->getStatus() == 1) {

                                $count++;

                                $message = Mage::helper('deven_automation/facebook_publisher')->generateMessage($product);

                                $coreUrl = Mage::getModel('core/url_rewrite');
                                $idPath = sprintf('product/%d', $product->getId());
                                $coreUrl->loadByIdPath($idPath);

                                $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB, false). $coreUrl->getRequestPath();

                                $image = Mage::helper('catalog/image')->init($product, 'image');

                                if(Mage::helper('deven_automation')->hasMultipleProductUploadImage()) {

                                    if($product->getImage() == 'no_selection') {

                                        if(Mage::helper('deven_automation/facebook')->isEnabledPostOnPage()) {
                                            Mage::getModel('deven_automation/facebook_product_publisher')
                                                ->scheduledPostOnPages($message,
                                                    $url, $image->__toString(),
                                                    $product->getName(),
                                                    $product->getShortDescription(),
                                                    false, $time->getTimestamp());
                                        }
                                    } else {

                                        if($image) {

                                            if(Mage::helper('deven_automation/facebook')->isEnabledPostOnPage()) {
                                                Mage::getModel('deven_automation/facebook_product_publisher')
                                                    ->scheduledPostPhotoOnPages($message, $image->__toString(), false, $time->getTimestamp());
                                            }
                                        }
                                    }

                                } else {

                                    if(Mage::helper('deven_automation/facebook')->isEnabledPostOnPage()) {
                                        Mage::getModel('deven_automation/facebook_product_publisher')
                                            ->scheduledPostOnPages($message,
                                                $url, $image->__toString(),
                                                $product->getName(),
                                                $product->getShortDescription(),
                                                false, $time->getTimestamp());
                                    }
                                }
                            }

                        }
                        $this->_getSession()->addSuccess(
                            $this->__('Total of %d product(s) have been scheduled to post on Facebook.', $count)
                        );
                    }

                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            } else {
                $this->_getSession()->addError(
                    $this->__('Please don\'t post over '. Mage::helper('deven_automation/facebook')->getLimitedNumber() .' products!')
                );
            }
        }
        $this->_redirect('*/*/index');
    }
} 