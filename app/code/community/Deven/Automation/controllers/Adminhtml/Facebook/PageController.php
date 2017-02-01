<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/10/2015
 * Time: 2:51 PM
 */

class Deven_Automation_Adminhtml_Facebook_PageController extends Mage_Adminhtml_Controller_Action  {

    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('deven_automation/adminhtml_facebook_page'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    public function syncAction()
    {
        try {
            $accessToken = Mage::getStoreConfig('automation/facebook/access_token');

            $client = Mage::getModel('deven_automation/facebook_client');

            $client->setAccessToken($accessToken);

            $response = $client->api('/me/accounts',
                'GET');

            if ($response->data) {

                Mage::getResourceModel('deven_automation/facebook_page')->truncate();

                foreach ($response->data as $data) {

                    $pageModel = Mage::getModel('deven_automation/facebook_page');

                    $pageModel->saveFacebookPageData($data);

                    $pageModel->save();
                }

                $this->_getSession()->addSuccess(Mage::helper('deven_automation')->__('Sync Facebook Pages with your database successfully'));

            }
        } catch(Exception $e) {
            $this->_getSession()->addError(Mage::helper('deven_automation')->__($e->getMessage()));
        }

        $this->_redirect('*/*/index');
    }

    public function viewAction()
    {
        $id = $this->getRequest()->getParam('id');

        $page = Mage::getModel('deven_automation/facebook_page')->load($id);

        $this->_redirectUrl('https://facebook.com/' . $page->getPageId());
    }

    public function changeEnablePostingAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        $page = Mage::getModel('deven_automation/facebook_page');

        if($id) {
            $page->load((int) $id);

            if($page->getId()) {
                ($page->getEnablePosting()==1) ? $page->setEnablePosting(0) : $page->setEnablePosting(1);
                $page->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('deven_automation')->__('Change enable posting successfully'));
                $this->_redirect('*/*/index');
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('deven_automation')->__('Page does not exist'));
                $this->_redirect('*/*/index');
            }
        }
    }

    public function massChangeEnablePostingAction()
    {
        $pageIds = $this->getRequest()->getParam('pages');

        if(!is_array($pageIds))
        {
            Mage::getSingleton('adminhtml/session')
                ->addError(Mage::helper('deven_automation')
                    ->__('Please select one or more pages'));
        } else {
            try {
                foreach($pageIds as $pageId)
                {
                    $page = Mage::getModel('deven_automation/facebook_page');

                    $page->load((int) $pageId);

                    ($page->getEnablePosting()==1) ? $page->setEnablePosting(0) : $page->setEnablePosting(1);
                    $page->save();
                }
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(
                        Mage::helper('adminhtml')->__('Total of %d record(s) were changed.', count($pageIds))
                    );
                $this->_redirect('*/*/index');
            } catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/index');
            }
        }
    }
} 