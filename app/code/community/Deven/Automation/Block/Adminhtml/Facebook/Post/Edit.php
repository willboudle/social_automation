<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 8/30/2015
 * Time: 2:48 PM
 */

class Deven_Automation_Block_Adminhtml_Facebook_Post_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'deven_automation';
        $this->_controller = 'adminhtml_facebook_post';
        $this->_mode = 'edit';

        $this->_updateButton('save', 'label', Mage::helper('deven_automation')->__('Post On Facebook'));
    }

    public function getHeaderText()
    {
        return Mage::helper('deven_automation')->__('Post Status on Facebook');
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', array('id' => $this->getRequest()->getParam('id')));
    }
} 