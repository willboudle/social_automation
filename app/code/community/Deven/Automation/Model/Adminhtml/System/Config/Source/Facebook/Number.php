<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/9/2015
 * Time: 1:06 PM
 */

class Deven_Automation_Model_Adminhtml_System_Config_Source_Facebook_Number {
    public function toOptionArray() {
        return array(
            array(
                'value' => 20,
                'label' => Mage::helper('deven_automation')->__('20'),
            ),
            array(
                'value' => 30,
                'label' => Mage::helper('deven_automation')->__('30'),
            ),
            array(
                'value' => 40,
                'label' => Mage::helper('deven_automation')->__('40'),
            ),
            array(
                'value' => 50,
                'label' => Mage::helper('deven_automation')->__('50'),
            )
        );
    }
}