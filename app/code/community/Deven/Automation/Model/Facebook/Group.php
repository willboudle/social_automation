<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/23/2015
 * Time: 1:14 PM
 */

class Deven_Automation_Model_Facebook_Group extends Mage_Core_Model_Abstract {

    public function _construct()
    {
        $this->_init('deven_automation/facebook_group');
        parent::_construct();
    }

    public function saveFacebookGroupData($response, $data)
    {
        try {
            if(!empty($response) && !empty($data))
            {
                $this->setGroupId($response->id);
                $this->setName($response->name);
                $this->setDescription($response->description);
                $this->setEnablePosting($data['enable_posting']);
            } else {
                throw new Exception("Error Processing Request: Insufficient Data Provided");
            }
        } catch(Exception $e) {
            Mage::logException($e);
        }

        return $this;
    }
} 