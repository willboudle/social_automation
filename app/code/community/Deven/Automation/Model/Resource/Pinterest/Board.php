<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/23/2015
 * Time: 1:24 PM
 */

class Deven_Automation_Model_Resource_Pinterest_Board extends Mage_Core_Model_Resource_Db_Abstract {

    public function _construct()
    {
        $this->_init('deven_automation/pinterest_board', 'id');
    }

    public function truncate() {
        $this->_getWriteAdapter()->query('TRUNCATE TABLE '.$this->getMainTable());
        return $this;
    }

    public function changeAutoIncrement($increment = 1) {
        $this->_getWriteAdapter()->query('ALTER TABLE '.$this->getMainTable().' AUTO_INCREMENT = '. $increment);
    }
} 