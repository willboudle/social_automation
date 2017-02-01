<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 8/29/2015
 * Time: 4:45 PM
 */

class Deven_Automation_Block_Adminhtml_Pinterest_Board_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();

        $this->setId('pinterest_board_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('name');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceSingleton('deven_automation/pinterest_board_collection');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('board_id', array(
            'index'     => 'board_id',
            'header'    => Mage::helper('deven_automation')->__('Board Id'),
            'type'      => 'text',
            'sortable'  => true,
            'width'     => '100px'
        ));

        $this->addColumn('name', array(
            'index'     => 'name',
            'header'    => Mage::helper('deven_automation')->__('Board Name'),
            'sortable'  => true,
        ));

        $this->addColumn('description', array(
            'index'     => 'description',
            'header'    => Mage::helper('deven_automation')->__('Board Description'),
            'sortable'  => true,
        ));

        $this->addColumn('enable_pinning', array(
            'index'     => 'enable_pinning',
            'header'    => Mage::helper('deven_automation')->__('Enable Pinning'),
            'sortable'  => false,
            'type'      => 'options',
            'options'   => Mage::getModel('deven_automation/adminhtml_source_pinterest_board_enable')->getOptionArray()
        ));

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('deven_automation')->__('Action'),
                'width'     => '150px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('deven_automation')->__('Switch Enable Pinning'),
                        'url'     => array(
                            'base'=>'*/*/changeEnablePinning',
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
                        'caption' => Mage::helper('deven_automation')->__('View Board'),
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
        $this->setMassactionIdField('board_id');
        $this->getMassactionBlock()->setFormFieldName('boards');

        $this->getMassactionBlock()->addItem('changeEnablePinning', array(
            'label'         => Mage::helper('deven_automation')->__('Switch Enable Pinning'),
            'url'           => $this->getUrl('*/*/massChangeEnablePinning'),
        ));
        $this->getMassactionBlock()->addItem('delete', array(
            'label'         => Mage::helper('deven_automation')->__('Delete'),
            'url'           => $this->getUrl('*/*/massDelete'),
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