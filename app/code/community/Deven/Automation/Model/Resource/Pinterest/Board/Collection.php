<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/23/2015
 * Time: 1:25 PM
 */

class Deven_Automation_Model_Resource_Pinterest_Board_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    protected function _construct()
    {
        $this->_init('deven_automation/pinterest_board');
        parent::_construct();
    }
} 