<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/10/2015
 * Time: 2:16 PM
 */

class Deven_Automation_Block_Adminhtml_Facebook_Page extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_headerText = Mage::helper('deven_automation')->__('Manage Facebook Pages');

        $this->_blockGroup = 'deven_automation';
        $this->_controller = 'adminhtml_facebook_page';
        $this->_addButton('sync', array(
            'label'     => 'Sync Facebook Pages',
            'onclick'   => 'setLocation(\''. $this->getUrl('adminhtml/facebook_page/sync'). '\')',
            'class'     => 'sync',
        ));

        parent::__construct();
        $this->_removeButton('add');
    }

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
} 