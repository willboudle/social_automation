<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 8/29/2015
 * Time: 4:45 PM
 */

class Deven_Automation_Block_Adminhtml_Facebook_Page_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();

        $this->setId('facebook_page_grid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setDefaultSort('name');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceSingleton('deven_automation/facebook_page_collection');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('page_id', array(
            'index'     => 'page_id',
            'header'    => Mage::helper('deven_automation')->__('Page Id'),
            'type'      => 'text',
            'sortable'  => true,
            'width'     => '100px'
        ));

        $this->addColumn('name', array(
            'index'     => 'name',
            'header'    => Mage::helper('deven_automation')->__('Page Name'),
            'sortable'  => true,
        ));

        $this->addColumn('category', array(
            'index'     => 'category',
            'header'    => Mage::helper('deven_automation')->__('Page Category'),
            'sortable'  => true,
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
                'width'     => '150px',
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
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
            ));

        $this->addColumn('view',
            array(
                'header'    => Mage::helper('deven_automation')->__('View'),
                'width'     => '150px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('deven_automation')->__('View Page'),
                        'url'     => array(
                            'base'=>'*/*/view',
                            'params'=>array('store'=>$this->getRequest()->getParam('store'))
                        ),
                        'target' => '_blank',
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
        $this->setMassactionIdField('page_id');
        $this->getMassactionBlock()->setFormFieldName('pages');

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