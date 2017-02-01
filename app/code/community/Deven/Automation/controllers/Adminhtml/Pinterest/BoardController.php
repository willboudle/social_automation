<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/10/2015
 * Time: 2:51 PM
 */

class Deven_Automation_Adminhtml_Pinterest_BoardController extends Mage_Adminhtml_Controller_Action  {

    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('deven_automation/adminhtml_pinterest_board'));

        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout(false);
        $this->renderLayout();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        $board = Mage::getModel('deven_automation/pinterest_board');

        if($id) {
            $board->load((int) $id);
            if($board->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

                if($data) {
                    $board->setData($data)->setId($id);
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('deven_automation')->__('Board does not exist'));
                $this->_redirect('');
            }
        }
        Mage::register('pinterest_board_data', $board);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function syncAction()
    {
        try {

            $client = Mage::getModel('deven_automation/pinterest_client');

            $response = $client->api('/me/boards/',
                'GET', array('fields' => 'id,name,url,description'));

            if ($response->data) {

                $boardModel = Mage::getModel('deven_automation/pinterest_board');

                Mage::getResourceModel('deven_automation/pinterest_board')->truncate();

                foreach ($response->data as $data) {

                    $boardModel->syncPinterestBoardData(1, $data);
                    $boardModel->unsetData('id');
                    $boardModel->save();
                }
            }

            $this->_getSession()->addSuccess(Mage::helper('deven_automation')->__('Sync Pinterest Boards with your database successfully'));

            $this->_redirect('*/*/index', array(
                'id' => $this->getRequest()->getParam('board_id')
            ));

        } catch(Exception $e) {
            $this->_getSession()->addError(Mage::helper('deven_automation')->__($e->getMessage()));
            $this->_redirect('*/*/index', array(
                'id'    => $this->getRequest()->getParam('board_id')
            ));
            return $this;
        }
    }

    public function saveAction()
    {
        if($this->getRequest()->getPost()) {

            try {

                $data = $this->getRequest()->getPost();

                $client = Mage::getModel('deven_automation/pinterest_client');

                $response = $client->api('/boards/',
                    'POST', array('name' => $data['name'], 'description' => $data['description']));

                $boardModel = Mage::getModel('deven_automation/pinterest_board');

                $boardModel->savePinterestBoardData($data, $response->data);
                $boardModel->save();

                $this->_getSession()->addSuccess(Mage::helper('deven_automation')->__('Save Pinterest Board successfully'));

                $this->_redirect('*/*/index', array(
                    'id' => $this->getRequest()->getParam('board_id')
                ));

            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('deven_automation')->__($e->getMessage()));
                $this->_redirect('*/*/edit', array(
                    'id' => $this->getRequest()->getParam('board_id')
                ));
                return $this;
            }
        }
    }

    public function deleteAction()
    {
        $boardId = $this->getRequest()->getParam('id');
        if($boardId) {
            try {

                $boardModel = Mage::getModel('deven_automation/pinterest_board');
                $board = $boardModel->load($boardId);

                $client = Mage::getModel('deven_automation/pinterest_client');

                $response = $client->api('/boards/' . $board->getBoardId() . '/',
                    'DELETE');

                if($response) {
                    $board->delete();
                    Mage::getSingleton('adminhtml/session')
                        ->addSuccess(
                            Mage::helper('adminhtml')->__('The record were deleted.')
                        );
                }
            } catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            $this->_redirect('*/*/index');
        }
    }

    public function changeEnablePinningAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        $board = Mage::getModel('deven_automation/pinterest_board');

        if($id) {
            $board->load((int) $id);

            if($board->getId()) {
                ($board->getEnablePinning()==1) ? $board->setEnablePinning(0) : $board->setEnablePinning(1);
                $board->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('deven_automation')->__('Change enable pinning successfully'));
                $this->_redirect('*/*/index');
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('deven_automation')->__('Board does not exist'));
                $this->_redirect('*/*/index');
            }
        }
    }

    public function viewAction()
    {
        $id = $this->getRequest()->getParam('id');

        $board = Mage::getModel('deven_automation/pinterest_board')->load($id);

        $this->_redirectUrl($board->getUrl());
    }

    public function massDeleteAction()
    {
        $boardIds = $this->getRequest()->getParam('boards');

        if(!is_array($boardIds))
        {
            Mage::getSingleton('adminhtml/session')
                ->addError(Mage::helper('deven_automation')
                    ->__('Please select one or more boards'));
        } else {
            try {
                $boardModel = Mage::getModel('deven_automation/pinterest_board');
                foreach($boardIds as $boardId)
                {
                    $board = $boardModel->load($boardId);

                    $client = Mage::getModel('deven_automation/pinterest_client');

                    $response = $client->api('/boards/' . $board->getBoardId() . '/',
                        'DELETE');

                    if($response) {
                        $board->delete();
                    }

                }
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(
                        Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($boardIds))
                    );
            } catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massChangeEnablePinningAction()
    {
        $boardIds = $this->getRequest()->getParam('boards');

        if(!is_array($boardIds))
        {
            Mage::getSingleton('adminhtml/session')
                ->addError(Mage::helper('deven_automation')
                    ->__('Please select one or more boards'));
        } else {
            try {
                $board = Mage::getModel('deven_automation/pinterest_board');
                foreach($boardIds as $boardId)
                {
                    $board->load((int) $boardId);

                    ($board->getEnablePinning()==1) ? $board->setEnablePinning(0) : $board->setEnablePinning(1);
                    $board->save();
                }
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(
                        Mage::helper('adminhtml')->__('Total of %d record(s) were changed.', count($boardIds))
                    );
            } catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
} 