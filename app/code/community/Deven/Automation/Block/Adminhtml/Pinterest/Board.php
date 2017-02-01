<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/10/2015
 * Time: 2:16 PM
 */

class Deven_Automation_Block_Adminhtml_Pinterest_Board extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_headerText = Mage::helper('deven_automation')->__('Manage Pinterest Boards');

        $this->_blockGroup = 'deven_automation';
        $this->_controller = 'adminhtml_pinterest_board';
        $this->_addButton('sync', array(
            'label'     => 'Sync Pinterest Boards',
            'onclick'   => 'setLocation(\''. $this->getUrl('adminhtml/pinterest_board/sync'). '\')',
            'class'     => 'sync',
        ));

        parent::__construct();
    }

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
} 