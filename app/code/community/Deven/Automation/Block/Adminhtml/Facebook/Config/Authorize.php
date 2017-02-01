<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 9/22/2015
 * Time: 10:19 PM
 */

class Deven_Automation_Block_Adminhtml_Facebook_Config_Authorize extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    public function __construct()
    {
        $this->client = Mage::getSingleton('deven_automation/facebook_client');

        $this->accessToken = Mage::getStoreConfig('automation/facebook/access_token');

        Mage::getSingleton('adminhtml/session')->setFacebookCsrf($csrf = md5(uniqid(rand(), TRUE)));
        $this->client->setState($csrf);
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);

        $url = $this->_getButtonUrl();

        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setType('button')
            ->setClass('scalable')
            ->setLabel($this->_getButtonText())
            ->setOnClick("setLocation('$url')")
            ->toHtml();

        return $html;
    }

    protected function _getButtonUrl()
    {
        if(!$this->accessToken) {
            return $this->client->createAuthUrl();
        } else {
            return Mage::helper('adminhtml')->getUrl('adminhtml/facebook/reauthorize');
        }

    }

    protected function _getButtonText()
    {
        if(!$this->accessToken) {
            $text = $this->__('Authorize');

        } else {
            $text = $this->__('Reauthorize');
        }

        return $text;
    }
}