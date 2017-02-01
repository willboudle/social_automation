<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/23/2015
 * Time: 1:25 PM
 */

class Deven_Automation_Model_Resource_Facebook_Group_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    protected function _construct()
    {
        $this->_init('deven_automation/facebook_group');
        parent::_construct();
    }
} 