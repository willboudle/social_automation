<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/31/2015
 * Time: 12:10 PM
 */

class Deven_Automation_Model_Adminhtml_System_Config_Source_Pinterest_Scheduled {
    public function toOptionArray() {
        return array(
            array(
                'value' => '*/15 * * * *',
                'label' => Mage::helper('deven_automation')->__('15 Minutes'),
            ),
            array(
                'value' => '*/30 * * * *',
                'label' => Mage::helper('deven_automation')->__('30 Minutes'),
            ),
            array(
                'value' => '*/45 * * * *',
                'label' => Mage::helper('deven_automation')->__('45 Minutes'),
            ),
            array(
                'value' => '0 * * * *',
                'label' => Mage::helper('deven_automation')->__('1 Hour'),
            ),
            array(
                'value' => '0 */2 * * *',
                'label' => Mage::helper('deven_automation')->__('2 Hours'),
            ),
            array(
                'value' => '0 */3 * * *',
                'label' => Mage::helper('deven_automation')->__('3 Hours'),
            ),
        );
    }
}