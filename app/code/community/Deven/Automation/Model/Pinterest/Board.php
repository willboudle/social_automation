<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/10/2015
 * Time: 4:49 PM
 */

class Deven_Automation_Model_Pinterest_Board extends Mage_Core_Model_Abstract {

    public function _construct()
    {
        $this->_init('deven_automation/pinterest_board');
        parent::_construct();
    }

    public function savePinterestBoardData($data, $response)
    {
        try {
            if(!empty($data) && !empty($data))
            {
                $this->setBoardId($response->id);
                $this->setName($data['name']);
                $this->setDescription($data['description']);
                $this->setUrl($response->url);
                $this->setEnablePinning($data['enable_pinning']);
            } else {
                throw new Exception("Error Processing Request: Insufficient Data Provided");
            }
        } catch(Exception $e) {
            Mage::logException($e);
        }

        return $this;
    }

    public function syncPinterestBoardData($enable_pinning, $response)
    {
        try {
            if(isset($enable_pinning) && !empty($response))
            {
                $this->setBoardId($response->id);
                $this->setName($response->name);
                $this->setDescription($response->description);
                $this->setUrl($response->url);
                $this->setEnablePinning($enable_pinning);
            } else {
                throw new Exception("Error Processing Request: Insufficient Data Provided");
            }
        } catch(Exception $e) {
            Mage::logException($e);
        }

        return $this;
    }
} 