<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/21/2015
 * Time: 2:03 PM
 */

class Deven_Automation_Block_Adminhtml_Facebook_Group extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_headerText = Mage::helper('deven_automation')->__('Manage Facebook Groups');

        $this->_blockGroup = 'deven_automation';
        $this->_controller = 'adminhtml_facebook_group';
        $this->_addButtonLabel = Mage::helper('deven_automation')->__('Add New Group');

        parent::__construct();
    }

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
} 