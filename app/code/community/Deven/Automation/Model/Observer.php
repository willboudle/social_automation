<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 3/29/2016
 * Time: 2:58 PM
 */

class Deven_Automation_Model_Observer {

    public function addMassAction($observer) {

        $block = $observer->getEvent()->getBlock();

        $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

        if(Mage::helper('deven_automation/facebook')->isEnabledPostMultipleArticles()) {
            if (get_class($block) == 'Mage_Adminhtml_Block_Widget_Grid_Massaction'
                && $block->getRequest()->getControllerName() == 'manage_blog'
            ) {
                $block->addItem('massPostArticle', array(
                    'label' => Mage::helper('deven_automation')->__('Post on Facebook'),
                    'url' => $block->getUrl('*/*/massPost')
                ));
            }
        }

        if(Mage::helper('deven_automation/facebook')->isEnabledMultipleProduct()) {
            if (get_class($block) == 'Mage_Adminhtml_Block_Widget_Grid_Massaction'
                && $block->getRequest()->getControllerName() == 'catalog_product'
            ) {
                $block->addItem('massPost', array(
                    'label' => Mage::helper('deven_automation')->__('Post on Facebook'),
                    'url' => $block->getUrl('*/*/massPost')
                ));

                $block->addItem('scheduledPost', array(
                    'label' => Mage::helper('deven_automation')->__('Scheduled Post on Pages'),
                    'url' => $block->getUrl('*/*/massScheduledPost'),
                    'additional' => array(
                        'visibility' => array(
                            'name' => 'post_time',
                            'type' => 'date',
                            'class' => 'required-entry',
                            'label' => Mage::helper('deven_automation')->__('Post Time'),
                            'image'  => $block->getSkinUrl('images/grid-cal.gif'),
                            'input_format' => $dateFormatIso,
                            'format'       => $dateFormatIso,
                            'time' => true
                        )
                    )
                ));
            }
        }

        if(Mage::helper('deven_automation/pinterest')->isEnabledMultipleProduct()) {
            if (get_class($block) == 'Mage_Adminhtml_Block_Widget_Grid_Massaction'
                && $block->getRequest()->getControllerName() == 'catalog_product'
            ) {
                $block->addItem('massPin', array(
                    'label' => 'Pin on Pinterest Boards',
                    'url' => $block->getUrl('*/*/massPin'),
                    'additional' => array(
                        'visibility' => array(
                            'name' => 'boards',
                            'type' => 'multiselect',
                            'class' => 'required-entry',
                            'style'    => 'height:100px',
                            'label' => Mage::helper('deven_automation')->__('Select Boards'),
                            'values'    => Mage::getSingleton('deven_automation/adminhtml_source_pinterest_board')->toOptionArray(),
                        )
                    )
                ));
            }
        }

        if(Mage::helper('deven_automation/twitter')->isEnabledMultipleProduct()) {

            if (get_class($block) == 'Mage_Adminhtml_Block_Widget_Grid_Massaction'
                && $block->getRequest()->getControllerName() == 'catalog_product'
            ) {
                $block->addItem('massTweet', array(
                    'label' => 'Update on Twitter',
                    'url' => $block->getUrl('*/*/massTweet')
                ));
            }
        }
    }

    public function publishNewProduct($observer) {

        if(!(Mage::app()->getRequest()->getParam('id'))) {

            $product = $observer->getProduct();

            if(Mage::helper('deven_automation/pinterest')->isEnabledNewProduct()) {

            $types = explode(',', Mage::helper('deven_automation/pinterest')->getEnableNewProductType());

            if($product->getVisibility() == Mage::helper('deven_automation/pinterest')->getEnableNewProductVisibility()
                && in_array($product->getTypeId(), $types)
                && $product->getStatus() == 1) {
                
                    try {
                        $boards = explode(',', Mage::helper('deven_automation/pinterest')->getEnableNewProductBoards());

                        $message = Mage::helper('deven_automation/pinterest_publisher')->generateMessage($product);

                        $coreUrl = Mage::getModel('core/url_rewrite');
                        $idPath = sprintf('product/%d', $product->getId());
                        $coreUrl->loadByIdPath($idPath);

                        $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB). $coreUrl->getRequestPath();

                        $image = Mage::helper('catalog/image')->init($product, 'image');

                        if($boards) {
                            Mage::getModel('deven_automation/pinterest_pin_publisher')->pinOnBoards($boards, $message, $url, $image->__toString());
                        }

                        Mage::getSingleton('adminhtml/session')->addSuccess(
                            Mage::Helper('deven_automation')->__('New product has been pinned on Pinterest.')
                        );

                    } catch (Exception $e) {
                        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    }

                }
                else {
                    Mage::getSingleton('adminhtml/session')->addError(
                        Mage::Helper('deven_automation')->__('New product can\'t be pinned on Pinterest because It\'s not visibility or is disabled on your website.')
                    );
                }
            }

            if(Mage::helper('deven_automation/facebook')->isEnabledNewProduct()) {
                $types = explode(',', Mage::helper('deven_automation/facebook')->getEnableNewProductType());

                if($product->getVisibility() == Mage::helper('deven_automation')->getEnableNewProductVisibility()
                    && in_array($product->getTypeId(), $types)
                    && $product->getStatus() == 1) {

                        try {

                            $message = Mage::helper('deven_automation/facebook_publisher')->generateMessage($product);

                            $coreUrl = Mage::getModel('core/url_rewrite');
                            $idPath = sprintf('product/%d', $product->getId());
                            $coreUrl->loadByIdPath($idPath);

                            $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB). $coreUrl->getRequestPath();

                            $image = Mage::helper('catalog/image')->init($product, 'image');

                            if(Mage::helper('deven_automation/facebook')->hasNewProductUploadImage()) {

                                if($image) {
                                    if($product->getImage() == 'no_selection') {
                                        Mage::getSingleton('adminhtml/session')->addError(
                                            Mage::Helper('deven_automation')->__('Please add image for product to update on Facebook!')
                                        );
                                        return;
                                    } else {
                                        if(Mage::helper('deven_automation/facebook')->isEnabledPostNewProductOnAllGroups()) {
                                            Mage::getModel('deven_automation/facebook_product_publisher')
                                                ->postPhotoOnGroups($message, $image->__toString());

                                        }

                                        if(Mage::helper('deven_automation/facebook')->isEnabledPostOnPage()) {
                                            Mage::getModel('deven_automation/facebook_product_publisher')
                                                ->postPhotoOnPages($message, $image->__toString());
                                            if(Mage::helper('deven_automation')->isEnabledPostOnBoth()) {
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
                                if(Mage::helper('deven_automation/facebook')->isEnabledPostNewProductOnAllGroups()) {
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
                            }

                            Mage::getSingleton('adminhtml/session')->addSuccess(
                                Mage::Helper('deven_automation')->__('New product has been posted on Facebook.')
                            );

                        } catch (Exception $e) {
                            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                        }

                } else {
                    Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('deven_automation')->__('New product can\'t be posted on Facebook because It\'s not visibility or is disabled on your website.')
                    );
                }
            }

            if(Mage::helper('deven_automation/twitter')->isEnabledNewProduct()) {
                $client = Mage::getModel('deven_automation/twitter_client');

                $types = explode(',', Mage::helper('deven_automation/twitter')->getEnableNewProductType());

                    if($product->getVisibility() == Mage::helper('deven_automation/twitter')->getEnableNewProductVisibility()
                        && in_array($product->getTypeId(), $types)
                        && $product->getStatus() == 1) {

                        try {

                            $message = Mage::helper('deven_automation/twitter_publisher')->generateTweet($product);

                            if(Mage::helper('deven_automation/twitter')->hasNewProductUploadImage()) {
                                $image = Mage::helper('catalog/image')->init($product, 'image');
                                if($image) {
                                    if($product->getImage() == 'no_selection') {
                                        Mage::getSingleton('adminhtml/session')->addError(
                                            Mage::Helper('deven_automation')->__('Please add image for product to update on Twitter!')
                                        );

                                        return;
                                    } else {
                                        $response = $client->api('/statuses/update_with_media.json', 'POST', array('status' => $message), true, $image->__toString(), 'media[]');
                                    }
                                }
                            } else {
                                $response = $client->api('/statuses/update.json', 'POST', array('status' => $message));
                            }

                            Mage::getSingleton('adminhtml/session')->addSuccess(
                                Mage::Helper('deven_automation')->__('New product have been updated on Twitter.')
                            );

                        } catch (Exception $e) {
                            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                        }
                    }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::Helper('deven_automation')->__('New product can\'t be updated on Twitter because It\'s not visibility or is disabled on your website.')
                );
            }
        }
    }

    public function postRandomlyProduct()
    {
        if(Mage::helper('deven_automation/facebook')->isEnabledAutoPostRandomlyProduct()) {
            $types = explode(',', Mage::helper('deven_automation/facebook')->getEnableMultipleProductType());
            $products = Mage::getModel('catalog/product')->getCollection();
            $products->addAttributeToSelect('*');
            $products->addFieldToFilter('visibility', array(
                Mage::helper('deven_automation/facebook')->getEnableMultipleProductVisibility()
            ));
            $products->addFieldToFilter('type_id', $types);
            $products->addFieldToFilter('is_in_stock');
            $products->getSelect()->order(new Zend_Db_Expr('RAND()'));
            $products->getSelect()->limit(1);

            foreach($products as $product) {

                if($product->getStatus() == 1) {

                    $message = Mage::helper('deven_automation/facebook_publisher')->generateMessage($product);

                    $coreUrl = Mage::getModel('core/url_rewrite');
                    $idPath = sprintf('product/%d', $product->getId());
                    $coreUrl->loadByIdPath($idPath);

                    $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB). $coreUrl->getRequestPath();

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
                    }
                }
            }
        }
    }

    public function pinRandomlyProduct() {
        if(Mage::helper('deven_automation/pinterest')->isEnabledAutopinRandomlyProduct()) {
            $types = explode(',', Mage::helper('deven_automation/pinterest')->getEnableMultipleProductType());
            $products = Mage::getModel('catalog/product')->getCollection();
            $products->addAttributeToSelect('*');
            $products->addFieldToFilter('visibility', array(
                Mage::helper('deven_automation/pinterest')->getEnableMultipleProductVisibility()
            ));
            $products->addFieldToFilter('type_id', $types);
            $products->addFieldToFilter('is_in_stock');
            $products->getSelect()->order(new Zend_Db_Expr('RAND()'));
            $products->getSelect()->limit(1);

            foreach($products as $product) {

                if($product->getStatus() == 1) {

                    $boards = explode(',', Mage::helper('deven_automation/pinterest')->getEnableNewProductBoards());

                    $message = Mage::helper('deven_automation/pinterest_publisher')->generateMessage($product);

                    $coreUrl = Mage::getModel('core/url_rewrite');
                    $idPath = sprintf('product/%d', $product->getId());
                    $coreUrl->loadByIdPath($idPath);

                    $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB). $coreUrl->getRequestPath();

                    $image = Mage::helper('catalog/image')->init($product, 'image');

                    if($boards) {
                        Mage::getModel('deven_automation/pinterest_pin_publisher')->pinOnBoards($boards, $message, $url, $image->__toString());
                    }
                }
            }
        }
    }

    public function tweetRandomlyProduct() {
        if(Mage::helper('deven_automation/twitter')->isEnabledAutotweetRandomlyProduct()) {
            $types = explode(',', Mage::helper('deven_automation/twitter')->getEnableMultipleProductType());
            $client = Mage::getModel('deven_automation/twitter_client');
            $products = Mage::getModel('catalog/product')->getCollection();
            $products->addAttributeToSelect('*');
            // add status
            $products->addAttributeToFilter('status', 1);
            $products->addFieldToFilter('visibility', array(
                Mage::helper('deven_automation/twitter')->getEnableMultipleProductVisibility()
            ));
            $products->addFieldToFilter('type_id', $types);
            $products->addFieldToFilter('is_in_stock');
            $products->getSelect()->order(new Zend_Db_Expr('RAND()'));
            $products->getSelect()->limit(1);
            foreach($products as $product) {
                    
                if ($product->getData('is_salable' == '1')) {

                    $message = Mage::helper('deven_automation/twitter_publisher')->generateTweet($product);

                    if(Mage::helper('deven_automation/twitter')->hasNewProductUploadImage()) {
                        $image = Mage::helper('catalog/image')->init($product, 'image');
                        if($image) {
                            $response = $client->api('/statuses/update_with_media.json', 'POST', array('status' => $message), true, $image->__toString(), 'media[]');
                        }
                    } else {
                        $response = $client->api('/statuses/update.json', 'POST', array('status' => $message));
                    }
                }
            }
        }
    }
} 