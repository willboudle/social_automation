<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/10/2015
 * Time: 4:49 PM
 */

class Deven_Automation_Model_Facebook_Page extends Mage_Core_Model_Abstract {

    public function _construct()
    {
        $this->_init('deven_automation/facebook_page');
        parent::_construct();
    }

    public function saveFacebookPageData($response)
    {
        try {
            if(!empty($response))
            {
                $this->setPageId($response->id);
                $this->setName($response->name);
                $this->setCategory($response->category);
                $this->setAccessToken($response->access_token);
                $this->setEnablePosting(1);
            } else {
                throw new Exception("Error Processing Request: Insufficient Data Provided");
            }
        } catch(Exception $e) {
            Mage::logException($e);
        }

        return $this;
    }
} 