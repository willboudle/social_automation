<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 8/29/2015
 * Time: 4:45 PM
 */

class Deven_Automation_Block_Adminhtml_Facebook_Group_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();

        $this->setId('facebook_group_grid');
        $this->setDefaultSort('name');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('facebook_group_filter');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceSingleton('deven_automation/facebook_group_collection');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('group_id', array(
            'index'     => 'group_id',
            'header'    => Mage::helper('deven_automation')->__('Group Id'),
            'type'      => 'text',
            'sortable'  => true,
            'width'     => '100px'
        ));

        $this->addColumn('name', array(
            'index'     => 'name',
            'header'    => Mage::helper('deven_automation')->__('Group Name'),
            'sortable'  => true,
        ));

        $this->addColumn('description', array(
            'index'     => 'description',
            'header'    => Mage::helper('deven_automation')->__('Group Description'),
            'sortable'  => false,
            'width'     => '700px'
        ));

        $this->addColumn('enable_posting', array(
            'index'     => 'enable_posting',
            'header'    => Mage::helper('deven_automation')->__('Enable Posting'),
            'sortable'  => false,
            'type'      => 'options',
            'options'   => Mage::getModel('deven_automation/adminhtml_source_facebook_group_enable')->getOptionArray()
        ));

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('deven_automation')->__('Action'),
                'width'     => '100px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('deven_automation')->__('Switch Enable Posting'),
                        'url'     => array(
                            'base'=>'*/*/changeEnablePosting',
                            'params'=>array('store'=>$this->getRequest()->getParam('store'))
                        ),
                        'field'   => 'id'
                    ),
                    array(
                        'caption' => Mage::helper('deven_automation')->__('Delete'),
                        'url'     => array(
                            'base'=>'*/*/delete',
                            'params'=>array('store'=>$this->getRequest()->getParam('store'))
                        ),
                        'confirm'       => Mage::helper('deven_automation')->__('Are you sure?'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
            ));



        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('group_id');
        $this->getMassactionBlock()->setFormFieldName('groups');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'         => Mage::helper('deven_automation')->__('Delete'),
            'url'           => $this->getUrl('*/*/massDelete'),
            'confirm'       => Mage::helper('deven_automation')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('changeEnablePosting', array(
            'label'         => Mage::helper('deven_automation')->__('Switch Enable Posting'),
            'url'           => $this->getUrl('*/*/massChangeEnablePosting'),
        ));

        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array(
            '_current'   => true,
        ));
    }

} 