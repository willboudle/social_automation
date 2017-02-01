<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/23/2015
 * Time: 1:24 PM
 */

class Deven_Automation_Model_Resource_Facebook_Group extends Mage_Core_Model_Resource_Db_Abstract {

    public function _construct()
    {
        $this->_init('deven_automation/facebook_group', 'id');
    }
} 