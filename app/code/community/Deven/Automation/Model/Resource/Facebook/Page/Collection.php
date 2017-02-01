<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/10/2015
 * Time: 4:49 PM
 */

class Deven_Automation_Model_Resource_Facebook_Page_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    protected function _construct()
    {
        $this->_init('deven_automation/facebook_page');
        parent::_construct();
    }
} 