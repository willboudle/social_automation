<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 8/30/2015
 * Time: 3:00 PM
 */

class Deven_Automation_Block_Adminhtml_Pinterest_Board_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'    => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array(
                'id'     => $this->getRequest()->getParam('id')
            )),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);


        $fieldset = $form->addFieldset('pinterest_board_form', array(
            'legend'    => Mage::helper('deven_automation')->__('Add New Pinterest Board')
        ));

        /*$fieldset->addField('board_id', 'text', array(
            'label'     => Mage::helper('deven_automation')->__('Board ID'),
            'required'  => true,
            'name'      => 'board_id'
        ));*/

        $fieldset->addField('name', 'text', array(
            'label'     => Mage::helper('deven_automation')->__('Board Name'),
            'required'  => true,
            'name'      => 'name'
        ));

        $fieldset->addField('description', 'textarea', array(
            'label'     => Mage::helper('deven_automation')->__('Description'),
            'required'  => true,
            'name'      => 'description'
        ));

        $fieldset->addField('enable_pinning', 'select', array(
            'label'     => Mage::helper('deven_automation')->__('Enable Pinning'),
            'required'  => true,
            'name'      => 'enable_pinning',
            'values'     => Mage::getModel('deven_automation/adminhtml_source_pinterest_board_enable')->toOptionArray(),
            'value'     => null,
        ));


        return parent::_prepareForm();
    }

} 