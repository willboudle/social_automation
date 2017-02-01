<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/25/2015
 * Time: 1:46 PM
 */

class Deven_Automation_Adminhtml_Pinterest_PinController extends Mage_Adminhtml_Controller_Action {

    public function editAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function pinOnPinterestAction()
    {
        if($this->getRequest()->getPost())
        {
            try {
                $data = $this->getRequest()->getPost();

                if($data) {

                    if(isset($data['boards'])) {
                        Mage::getModel('deven_automation/pinterest_pin_publisher')
                            ->pinOnBoards($data['boards'],
                                        $data['note'],
                                        $data['link'],
                                        $data['image_url']);
                    }

                    $this->_getSession()->addSuccess(Mage::helper('deven_automation')->__('You have pinned on Pinterest successfully'));

                    $this->_redirect('*/*/edit', array(
                        'id'    => $this->getRequest()->getParam('pin_id')
                    ));
                }
            } catch(Exception $e) {
                $this->_getSession()->addError(Mage::helper('deven_automation')->__($e->getMessage()));
                $this->_redirect('*/*/edit', array(
                    'id'    => $this->getRequest()->getParam('pin_id')
                ));
                return $this;
            }
        }
    }
} 