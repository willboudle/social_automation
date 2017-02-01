<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 8/30/2015
 * Time: 2:48 PM
 */

class Deven_Automation_Block_Adminhtml_Facebook_Group_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'deven_automation';
        $this->_controller = 'adminhtml_facebook_group';
        $this->_mode = 'edit';

        $this->_updateButton('save', 'label', Mage::helper('deven_automation')->__('Save Facebook Group'));
        $this->_updateButton('delete', 'label', Mage::helper('deven_automation')->__('Delete Facebook Group'));
    }

    public function getHeaderText()
    {
        if(Mage::registry('facebook_group_data') && Mage::registry('facebook_group_data')->getId())
            return Mage::helper('deven_automation')->__("Edit Group '%s'",
                $this->escapeHtml(Mage::registry('facebook_group_data'))
                    ->getName());
        return Mage::helper('deven_automation')->__('Add New Group');
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', array('id' => $this->getRequest()->getParam('id')));
    }
} 