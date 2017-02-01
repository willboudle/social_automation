<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/23/2015
 * Time: 12:52 PM
 */

class Deven_Automation_Model_Adminhtml_Source_Facebook_Group_Enable {

    public function toOptionArray()
    {
        return array(
            array(
                'value' => null,
                'label' => Mage::helper('deven_automation')->__('--Please Select--'),
            ),
            array(
                'value' => 1,
                'label' => Mage::helper('deven_automation')->__('Enable'),
            ),
            array(
                'value' => 0,
                'label' => Mage::helper('deven_automation')->__('Disable'),
            ),
        );
    }

    public function getOptionArray()
    {
        return array(
            1 => 'Enable',
            0 => 'Disable'
        );
    }
} 