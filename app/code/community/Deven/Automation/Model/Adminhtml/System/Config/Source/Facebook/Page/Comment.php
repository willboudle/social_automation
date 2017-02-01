<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/9/2015
 * Time: 10:25 AM
 */

class Deven_Automation_Model_Adminhtml_System_Config_Source_Facebook_Page_Comment extends Mage_Core_Model_Config_Data {

    public function __construct()
    {
        $this->accessToken = Mage::getStoreConfig('automation/facebook/page_access_token');
    }

    public function getCommentText(Mage_Core_Model_Config_Element $element, $currentValue)
    {
        if(!$this->accessToken) {
            return "You have not connected to your page. If you want you can click <a href=\"". Mage::helper("adminhtml")->getUrl("adminhtml/facebook/getPageAccessToken") ."\">here</a> to connect with your page.</p>";
        } else {
            $token = json_decode($this->accessToken);

            $text = "<p>You have connected to page: ";

            foreach ($token as $tk) {
                $text .= '<br> -  <b>' . $tk->name . '</b>';
            }

            $text .= "<br> Expires at: <b>Never</b>";

            return $text;
        }
    }
}