<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 8/30/2015
 * Time: 3:00 PM
 */

class Deven_Automation_Block_Adminhtml_Facebook_Group_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

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


        $fieldset = $form->addFieldset('facebook_group_form', array(
            'legend'    => Mage::helper('deven_automation')->__('Add New Facebook Group')
        ));

        $fieldset->addField('group_id', 'text', array(
            'label'     => Mage::helper('deven_automation')->__('Group ID'),
            'required'  => true,
            'name'      => 'group_id'
        ));

        $fieldset->addField('enable_posting', 'select', array(
            'label'     => Mage::helper('deven_automation')->__('Enable Posting'),
            'required'  => true,
            'name'      => 'enable_posting',
            'values'     => Mage::getModel('deven_automation/adminhtml_source_facebook_group_enable')->toOptionArray(),
            'value'     => null,
        ));


        return parent::_prepareForm();
    }

} 