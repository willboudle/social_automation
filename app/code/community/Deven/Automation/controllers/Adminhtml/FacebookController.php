<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 3/27/2016
 * Time: 2:37 PM
 */

class Deven_Automation_Adminhtml_FacebookController extends Mage_Adminhtml_Controller_Action {

    protected $_publicActions = array('authorize', 'reauthorize', 'deauthorize');

    public function authorizeAction() {

        try {
            $this->_connectCallback();
        } catch(Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirectSuccess(Mage::getModel('adminhtml/url')->getUrl("adminhtml/system_config/edit/section/automation"));
    }


    public function reauthorizeAction()
    {
        try {
            $this->_disconnectCallback();

            $client = Mage::getModel('deven_automation/facebook_client');

            Mage::getSingleton('adminhtml/session')->setFacebookCsrf($csrf = md5(uniqid(rand(), TRUE)));
            $client->setState($csrf);

            $this->_redirectUrl($client->createAuthUrl());

        } catch(Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
    }

    public function deauthorizeAction() {

        try {
            $this->_disconnectCallback();
            Mage::getSingleton('adminhtml/session')->addSuccess(
                $this->__('You have deauthorized successfully!')
            );
        } catch(Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirectSuccess(Mage::getModel('adminhtml/url')->getUrl("adminhtml/system_config/edit/section/automation"));
    }

    protected function _disconnectCallback() {

        $accessToken = Mage::getStoreConfig('automation/facebook/access_token');
        $client = Mage::getSingleton('deven_automation/facebook_client');

        $client->setAccessToken($accessToken);
        $client->api('/me/permissions', 'DELETE');

        $config = new Mage_Core_Model_Config();

        $config->saveConfig('automation/facebook/access_token', null, 'default', 0 );
        $config->saveConfig('automation/facebook/facebook_id', null, 'default', 0 );
        $config->saveConfig('automation/facebook/page_access_token', null, 'default', 0 );

        Mage::app()->getCacheInstance()->cleanType('config');
    }

    protected function _connectCallback() {
        $errorCode = $this->getRequest()->getParam('error');
        $code = $this->getRequest()->getParam('code');
        $state = $this->getRequest()->getParam('state');

        if(!($errorCode || $code) && !$state) {
            // Direct route access - deny
            return $this;
        }

        if(!$state || $state != Mage::getSingleton('adminhtml/session')->getFacebookCsrf()) {
            return $this;
        }

        if($errorCode) {
            // Facebook API read light - abort
            if($errorCode === 'access_denied') {
                Mage::getSingleton('adminhtml/session')
                    ->addNotice(
                        $this->__('Facebook Connect process aborted.')
                    );

                return $this;
            }

            throw new Exception(
                sprintf(
                    $this->__('Sorry, "%s" error occured. Please try again.'),
                    $errorCode
                )
            );
        }

        if ($code) {
            // Facebook API green light - proceed
            $client = Mage::getSingleton('deven_automation/facebook_client');

            $userInfo = $client->api('/me',
                'GET',
                array(
                    'fields' =>
                        'id'
                ));
            $token = $client->getAccessToken();

            $config = new Mage_Core_Model_Config();

            $config->saveConfig('automation/facebook/access_token', $token, 'default', 0 );
            $config->saveConfig('automation/facebook/facebook_id', $userInfo->id, 'default', 0 );
            Mage::app()->getCacheInstance()->cleanType('config');

            Mage::getSingleton('adminhtml/session')->addSuccess(
                $this->__('You have authorized successfully!')
            );
        }
    }
} 