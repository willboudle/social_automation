<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 8/30/2015
 * Time: 3:00 PM
 */

class Deven_Automation_Block_Adminhtml_Pinterest_Pin_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'    => 'edit_form',
            'action'    => $this->getUrl('*/*/pinOnPinterest', array(
                'id'     => $this->getRequest()->getParam('id')
            )),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset('pinterest_pin_form', array(
            'legend'    => Mage::helper('deven_automation')->__('Pin on Pinterest')
        ));

        $fieldset->addField('boards', 'multiselect', array(
            'label'     => Mage::helper('deven_automation')->__('Boards you want to pin to'),
            'name'      => 'boards',
            'values'    => Mage::getSingleton('deven_automation/adminhtml_source_pinterest_board')->toOptionArray(),
        ));

        $fieldset->addField('note', 'textarea', array(
            'label'     => Mage::helper('deven_automation')->__('Note'),
            'required'  => false,
            'name'      => 'note'
        ));


        $fieldset->addField('link', 'text', array(
            'label'     => Mage::helper('deven_automation')->__('Link'),
            'required'  => false,
            'name'      => 'link'
        ));

        $fieldset->addField('image_url', 'text', array(
            'label'     => Mage::helper('deven_automation')->__('Image URL'),
            'required'  => false,
            'name'      => 'image_url'
        ));

        return parent::_prepareForm();
    }

} 