<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/26/2015
 * Time: 10:16 AM
 */

class Deven_Automation_Model_Adminhtml_Source_Facebook_Post_Type {

    public function toOptionArray()
    {
        return array(
            array(
                'value' => '1',
                'label' => Mage::helper('deven_automation')->__('Message'),
            ),
            array(
                'value' => '2',
                'label' => Mage::helper('deven_automation')->__('Link'),
            ),
            array(
                'value' => '3',
                'label' => Mage::helper('deven_automation')->__('Photo'),
            )
        );
    }

    public function getOptionArray()
    {
        return array(
            '1' => 'Enable',
            '0' => 'Disable'
        );
    }
} 