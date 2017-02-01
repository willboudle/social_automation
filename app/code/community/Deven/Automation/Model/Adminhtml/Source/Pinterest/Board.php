<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/26/2015
 * Time: 1:42 PM
 */

class Deven_Automation_Model_Adminhtml_Source_Pinterest_Board {

    public function getOptionArray()
    {
        $boards = Mage::getModel('deven_automation/pinterest_board')->getCollection();

        $options = array();
        foreach($boards as $board) {
            $options[$board->getGroupId()] = Mage::helper('deven_automation')->__($board->getName());
        }

        return $options;
    }

    public function toOptionArray()
    {
        $boards = Mage::getModel('deven_automation/pinterest_board')->getCollection();
        $optionArray = array();

        if($boards) {
            foreach ($boards as $board) {
                if($board->getEnablePinning()==1) {
                    $optionArray[] = array(
                        'value'     => $board->getBoardId(),
                        'label'     => $board->getName()
                    );
                }
            }

            return $optionArray;
        }
    }

} 