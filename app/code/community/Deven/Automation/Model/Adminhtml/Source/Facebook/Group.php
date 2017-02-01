<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/26/2015
 * Time: 1:42 PM
 */

class Deven_Automation_Model_Adminhtml_Source_Facebook_Group {

    public function getOptionArray()
    {
        $groups = Mage::getModel('deven_automation/facebook_group')->getCollection();

        $options = array();
        foreach($groups as $groups) {
            $options[$groups->getGroupId()] = Mage::helper('deven_automation')->__($groups->getName());
        }

        return $options;
    }

    public function toOptionArray()
    {
        $groups = Mage::getModel('deven_automation/facebook_group')->getCollection();
        $optionArray = array();

        if($groups) {
            foreach ($groups as $group) {
                if($group->getEnablePosting()==1) {
                    $optionArray[] = array(
                        'value'     => $group->getGroupId(),
                        'label'     => $group->getName()
                    );
                }
            }

            return $optionArray;
        }
    }

} 