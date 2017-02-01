<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/21/2015
 * Time: 1:46 PM
 */

class Deven_Automation_Adminhtml_Facebook_GroupController extends Mage_Adminhtml_Controller_Action {

    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('deven_automation/adminhtml_facebook_group'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        $group = Mage::getModel('deven_automation/facebook_group');

        if($id) {
            $group->load((int) $id);
            if($group->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

                if($data) {
                    $group->setData($data)->setId($id);
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('deven_automation')->__('Group does not exist'));
                $this->_redirect('');
            }
        }
        Mage::register('facebook_group_data', $group);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        if($this->getRequest()->getPost())
        {
            try {
                $data = $this->getRequest()->getPost();

                if($data) {

                    $id = $data['group_id'];

                    $accessToken = Mage::getStoreConfig('automation/facebook/access_token');

                    $client = Mage::getModel('deven_automation/facebook_client');

                    $client->setAccessToken($accessToken);

                    $response = $client->api("/$id",
                        'GET', array(
                            'fields' => 'id, name, description'
                        ));

                    $groupModel = Mage::getModel('deven_automation/facebook_group');

                    $groupModel->saveFacebookGroupData($response, $data);

                    $groupModel->save();

                    $this->_getSession()->addSuccess(Mage::helper('deven_automation')->__('Add new Facebook group successfully'));
                    $this->_redirect('*/*/index', array(
                        'id'    => $this->getRequest()->getParam('group_id')
                    ));
                }
            } catch(Exception $e) {
                $this->_getSession()->addError(Mage::helper('deven_automation')->__($e->getMessage()));
                $this->_redirect('*/*/edit', array(
                    'id'    => $this->getRequest()->getParam('group_id')
                ));
                return $this;
            }
        }
    }

    public function changeEnablePostingAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        $group = Mage::getModel('deven_automation/facebook_group');

        if($id) {
            $group->load((int) $id);

            if($group->getId()) {
                ($group->getEnablePosting()==1) ? $group->setEnablePosting(0) : $group->setEnablePosting(1);
                $group->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('deven_automation')->__('Change enable posting successfully'));
                $this->_redirect('*/*/index');
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('deven_automation')->__('Group does not exist'));
                $this->_redirect('*/*/index');
            }
        }
    }

    public function deleteAction()
    {
        $groupId = $this->getRequest()->getParam('id');
        if($groupId) {
            try {
                $group = Mage::getModel('deven_automation/facebook_group');
                $group->load($groupId)
                    ->delete();
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(
                        Mage::helper('adminhtml')->__('The record were deleted.')
                    );
            } catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            $this->_redirect('*/*/index');
        }
    }

    public function massDeleteAction()
    {
        $groupIds = $this->getRequest()->getParam('groups');

        if(!is_array($groupIds))
        {
            Mage::getSingleton('adminhtml/session')
                ->addError(Mage::helper('deven_automation')
                    ->__('Please select one or more groups'));
        } else {
            try {

                foreach($groupIds as $groupId)
                {
                    $group = Mage::getModel('deven_automation/facebook_group');

                    $group->load($groupId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(
                        Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($groupIds))
                    );
                $this->_redirect('*/*/index');
            } catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/index');
            }
        }
    }

    public function massChangeEnablePostingAction()
    {
        $groupIds = $this->getRequest()->getParam('groups');

        if(!is_array($groupIds))
        {
            Mage::getSingleton('adminhtml/session')
                ->addError(Mage::helper('deven_automation')
                    ->__('Please select one or more groups'));
        } else {
            try {

                foreach($groupIds as $groupId)
                {
                    $group = Mage::getModel('deven_automation/facebook_group');

                    $group->load((int) $groupId);

                    ($group->getEnablePosting()==1) ? $group->setEnablePosting(0) : $group->setEnablePosting(1);
                    $group->save();
                }
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(
                        Mage::helper('adminhtml')->__('Total of %d record(s) were changed.', count($groupIds))
                    );
            } catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
} 