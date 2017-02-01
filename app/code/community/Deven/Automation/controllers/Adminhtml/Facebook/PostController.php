<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/25/2015
 * Time: 1:46 PM
 */

class Deven_Automation_Adminhtml_Facebook_PostController extends Mage_Adminhtml_Controller_Action {

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

    public function postOnFacebookAction()
    {
        if($this->getRequest()->getPost())
        {
            try {
                $data = $this->getRequest()->getPost();

                if($data) {

                    if($data['post_type']==1) {

                        if(isset($data['post_on_timeline'])) {
                            Mage::getModel('deven_automation/facebook_status_publisher')->postMessageOnProfile($data['message']);
                        }

                        if(isset($data['groups'])) {
                            Mage::getModel('deven_automation/facebook_status_publisher')->postMessageOnGroups($data['groups'], $data['message']);
                        }

                        if(isset($data['post_on_all_pages'])) {
                            Mage::getModel('deven_automation/facebook_status_publisher')->postMessageOnPages($data['message']);
                        }
                    }

                    if($data['post_type']==2) {

                        if(isset($data['post_on_timeline'])) {
                            Mage::getModel('deven_automation/facebook_status_publisher')
                                ->postLinkOnProfile($data['link_message'],
                                                    $data['link'],
                                                    $data['link_caption'],
                                                    $data['link_picture'],
                                                    $data['link_name'],
                                                    $data['link_description']);
                        }

                        if(isset($data['groups'])) {
                            Mage::getModel('deven_automation/facebook_status_publisher')
                                ->postLinkOnGroups($data['groups'],
                                            $data['link_message'],
                                            $data['link'],
                                            $data['link_caption'],
                                            $data['link_picture'],
                                            $data['link_name'],
                                            $data['link_description']);
                        }

                        if(isset($data['post_on_all_pages'])) {
                            Mage::getModel('deven_automation/facebook_status_publisher')
                                ->postLinkOnPages(
                                    $data['link_message'],
                                    $data['link'],
                                    $data['link_caption'],
                                    $data['link_picture'],
                                    $data['link_name'],
                                    $data['link_description']);
                        }
                    }

                    if($data['post_type']==3) {

                        if(isset($data['post_on_timeline'])) {
                            Mage::getModel('deven_automation/facebook_status_publisher')
                                ->postPhotoOnProfile($data['photo_caption'], $data['photo_url']);
                        }

                        if(isset($data['groups'])) {
                            Mage::getModel('deven_automation/facebook_status_publisher')
                                ->postPhotoOnGroups($data['groups'], $data['photo_caption'], $data['photo_url']);
                        }

                        if(isset($data['post_on_all_pages'])) {
                            Mage::getModel('deven_automation/facebook_status_publisher')
                                ->postPhotoOnPages($data['photo_caption'], $data['photo_url']);
                        }
                    }

                    /*if($data['post_type']==4) {

                        if($data['post_on_timeline']) {
                            $accessToken = Mage::getStoreConfig('automation/facebook/access_token');
                            $client->setAccessToken($accessToken);
                            $client->apiVideo('/me/videos', 'POST', array('title' => $data['video_title'], 'description' => $data['video_description'], 'file_url' => $data['video_url']));
                        }

                        if(!empty($groups)) {
                            foreach($groups as $group) {
                                $client->apiVideo("/$group->id/videos", 'POST', array('title' => $data['video_title'], 'description' => $data['video_description'], 'file_url' => $data['video_url']));
                            }
                        }

                        if($data['post_on_all_pages']) {

                            $pageTokens = json_decode(Mage::getStoreConfig('automation/facebook/page_access_token'));

                            if($pageTokens) {
                                foreach($pageTokens as $pageToken) {
                                    $client->setAccessToken(json_encode($pageToken));
                                    $client->apiVideo('/me/videos', 'POST', array('title' => $data['video_title'], 'description' => $data['video_description'], 'file_url' => $data['video_url']));
                                }
                            }
                        }
                    }*/


                    $this->_getSession()->addSuccess(Mage::helper('deven_automation')->__('You have posted on Facebook successfully'));

                    $this->_redirect('*/*/edit', array(
                        'id'    => $this->getRequest()->getParam('post_id')
                    ));
                }
            } catch(Exception $e) {
                $this->_getSession()->addError(Mage::helper('deven_automation')->__($e->getMessage()));
                $this->_redirect('*/*/edit', array(
                    'id'    => $this->getRequest()->getParam('post_id')
                ));
                return $this;
            }
        }
    }
} 