<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/7/2015
 * Time: 1:57 PM
 */

class Deven_Automation_Model_Adminhtml_System_Config_Source_Facebook_Comment extends Mage_Core_Model_Config_Data {

    public function __construct()
    {
        $this->client = Mage::getSingleton('deven_automation/facebook_client');

        $this->accessToken = Mage::getStoreConfig('automation/facebook/access_token');

        if($this->accessToken)
        {
            try{
                $this->client->setAccessToken($this->accessToken);
                $this->data = $this->client->debugToken();
            } catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
    }

    public function getCommentText(Mage_Core_Model_Config_Element $element, $currentValue)
    {
        if(!$this->data) {
            return "You have no authorization";
        } else {
            $expires_date = ($this->data->data->expires_at!=0) ? date('m-d-Y', $this->data->data->expires_at) : "Never";
            $text = "<p>You have connected to application: <b>" . $this->data->data->application
                . "</b><br> Issued at: <b>" . date('m-d-Y', $this->data->data->issued_at)
                . "</b><br> Expires at: <b>". $expires_date
                ."</b><br> User ID: <b>" . $this->data->data->user_id
                ."</b><br> You should click to reauthorize to get a new access token before expired date.
                 If you want you can click <a href=\"". Mage::helper("adminhtml")->getUrl("adminhtml/facebook/deauthorize") ."\">here</a> to deauthorize</p>";

            return $text;
        }
    }
} 