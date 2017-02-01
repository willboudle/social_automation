<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 8/30/2015
 * Time: 3:00 PM
 */

class Deven_Automation_Block_Adminhtml_Facebook_Post_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'    => 'edit_form',
            'action'    => $this->getUrl('*/*/postOnFacebook', array(
                'id'     => $this->getRequest()->getParam('id')
            )),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset('facebook_post_form', array(
            'legend'    => Mage::helper('deven_automation')->__('Post on Facebook')
        ));

        $fieldset->addField('groups', 'multiselect', array(
            'label'     => Mage::helper('deven_automation')->__('Groups you want to post to'),
            'name'      => 'groups',
            'values'    => Mage::getSingleton('deven_automation/adminhtml_source_facebook_group')->toOptionArray(),
        ));

        $fieldset->addField('post_on_timeline', 'checkbox', array(
            'label'     => Mage::helper('deven_automation')->__('Post on your time line'),
            'name'      => 'post_on_timeline',
            'value'     => '1'
        ));

        $fieldset->addField('post_on_all_pages', 'checkbox', array(
            'label'     => Mage::helper('deven_automation')->__('Post on all pages'),
            'name'      => 'post_on_all_pages',
            'value'     => '1'
        ));

        $fieldset->addField('post_type', 'select', array(
            'label'     => Mage::helper('deven_automation')->__('Post Type'),
            'required'  => true,
            'name'      => 'post_type',
            'values'     => Mage::getModel('deven_automation/adminhtml_source_facebook_post_type')->toOptionArray()
        ));

        $fieldset->addField('message', 'textarea', array(
            'label'     => Mage::helper('deven_automation')->__('Message'),
            'required'  => false,
            'name'      => 'message'
        ));

        $fieldset->addField('link_message', 'textarea', array(
            'label'     => Mage::helper('deven_automation')->__('Link Message'),
            'required'  => false,
            'name'      => 'link_message'
        ));

        $fieldset->addField('link', 'text', array(
            'label'     => Mage::helper('deven_automation')->__('Link'),
            'required'  => false,
            'name'      => 'link'
        ));

        $fieldset->addField('link_picture', 'text', array(
            'label'     => Mage::helper('deven_automation')->__('Link Picture'),
            'required'  => false,
            'name'      => 'link_picture'
        ));

        $fieldset->addField('link_name', 'text', array(
            'label'     => Mage::helper('deven_automation')->__('Link Title'),
            'required'  => false,
            'name'      => 'link_name'
        ));

        $fieldset->addField('link_caption', 'textarea', array(
            'label'     => Mage::helper('deven_automation')->__('Link Caption'),
            'required'  => false,
            'name'      => 'link_caption'
        ));

        $fieldset->addField('link_description', 'textarea', array(
            'label'     => Mage::helper('deven_automation')->__('Link Description'),
            'required'  => false,
            'name'      => 'link_description'
        ));

        $fieldset->addField('photo_url', 'text', array(
            'label'     => Mage::helper('deven_automation')->__('Photo URL'),
            'required'  => false,
            'name'      => 'photo_url'
        ));

        $fieldset->addField('photo_caption', 'textarea', array(
            'label'     => Mage::helper('deven_automation')->__('Photo Caption'),
            'required'  => false,
            'name'      => 'photo_caption'
        ));

        /*$fieldset->addField('video_url', 'text', array(
            'label'     => Mage::helper('deven_automation')->__('Video URL'),
            'required'  => false,
            'name'      => 'video_url'
        ));

        $fieldset->addField('video_title', 'text', array(
            'label'     => Mage::helper('deven_automation')->__('Video Title'),
            'required'  => false,
            'name'      => 'video_title'
        ));

        $fieldset->addField('video_description', 'textarea', array(
            'label'     => Mage::helper('deven_automation')->__('Video Description'),
            'required'  => false,
            'name'      => 'video_description'
        ));*/

        return parent::_prepareForm();
    }

    protected function _toHtml()
    {
        $dependency_block = $this->getLayout()
            ->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap('post_type', 'post_type')
            ->addFieldMap('message', 'message')
            ->addFieldMap('link_message', 'link_message')
            ->addFieldMap('link', 'link')
            ->addFieldMap('link_name', 'link_name')
            ->addFieldMap('link_picture', 'link_picture')
            ->addFieldMap('link_caption', 'link_caption')
            ->addFieldMap('link_description', 'link_description')
            ->addFieldMap('photo_url', 'photo_url')
            ->addFieldMap('photo_caption', 'photo_caption')
            /*->addFieldMap('video_url', 'video_url')
            ->addFieldMap('video_title', 'video_title')
            ->addFieldMap('video_description', 'video_description')*/
            ->addFieldDependence('message' , 'post_type', 1)
            ->addFieldDependence('link_message' , 'post_type', 2)
            ->addFieldDependence('link', 'post_type', 2)
            ->addFieldDependence('link_name', 'post_type', 2)
            ->addFieldDependence('link_picture', 'post_type', 2)
            ->addFieldDependence('link_caption', 'post_type', 2)
            ->addFieldDependence('link_description', 'post_type', 2)
            ->addFieldDependence('photo_url', 'post_type', 3)
            ->addFieldDependence('photo_caption', 'post_type', 3)
            /*->addFieldDependence('video_url', 'post_type', 4)
            ->addFieldDependence('video_title', 'post_type', 4)
            ->addFieldDependence('video_description', 'post_type', 4)*/;

        return parent::_toHtml() . $dependency_block->toHtml();
    }

} 