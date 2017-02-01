<?php

/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/17/2015
 * Time: 10:33 AM
 */
if(Mage::helper('core')->isModuleEnabled('AW_Blog')) {

    require_once 'AW/Blog/controllers/Manage/BlogController.php';

    class Deven_Automation_Manage_BlogController extends AW_Blog_Manage_BlogController {

        public function massPostAction()
        {
            $client = Mage::getModel('deven_automation/facebook_client');

            $blogIds = $this->getRequest()->getParam('blog');

            if (!is_array($blogIds)) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('Please select post(s)'));
            } else {

                if(count($blogIds) <= Mage::helper('deven_automation/facebook')->getArticlesLimitedNumber()) {

                    try {

                        if(Mage::helper('deven_automation/facebook')->isEnabledPostMultipleArticles()) {

                            foreach ($blogIds as $blogId) {

                                $blog = Mage::getModel('blog/blog')
                                    ->load($blogId);

                                $message = '';

                                $title = $blog->getTitle() . ' - ';
                                $content = $blog->getPostContent();
                                $shortContent = $blog->getShortContent();
                                $url = Mage::app()->getDefaultStoreView()->getBaseUrl().'blog/'.$blog->getIdentifier();

                                if(Mage::helper('deven_automation/facebook')->isJustPostMultipleArticlesTitleAndContent()) {
                                    $message .= $title . $content;
                                } else {
                                    if(Mage::helper('deven_automation/facebook')->hasPostMultipleArticlesTitle()) {
                                        $message .= $title;
                                    }

                                    if(Mage::helper('deven_automation/facebook')->hasPostMultipleArtilesShortDescription()) {
                                        $message .= $shortContent;
                                    }

                                    if(Mage::helper('deven_automation/facebook')->hasPostMultipleArticlesDisplayUrl()) {

                                        if(Mage::helper('deven_automation/facebook')->isPostMultipleArticlesShortenUrl()) {
                                            $url = Mage::helper('deven_automation')->shortenUrl($url);
                                        }

                                        $message .= ' See more at '. $url;
                                    }
                                }


                                $final_message = Mage::helper('blog')->stripTags($message);

                                if(Mage::helper('deven_automation/facebook')->isEnabledPostMultipleProductOnAllGroups()) {
                                    Mage::getModel('deven_automation/facebook_blog_publisher')
                                        ->postOnGroups($final_message,
                                            $url,
                                            $blog->getTitle(),
                                            $blog->getShortContent());
                                }

                                if(Mage::helper('deven_automation/facebook')->isEnabledPostOnPage()) {
                                    Mage::getModel('deven_automation/facebook_blog_publisher')
                                        ->postOnPages($final_message,
                                            $url,
                                            $blog->getTitle(),
                                            $blog->getShortContent());

                                    if(Mage::helper('deven_automation/facebook')->isEnabledPostOnBoth()) {
                                        Mage::getModel('deven_automation/facebook_blog_publisher')
                                            ->postOnProfile($final_message,
                                                $url,
                                                $blog->getTitle(),
                                                $blog->getShortContent());
                                    }
                                } else {
                                    Mage::getModel('deven_automation/facebook_blog_publisher')
                                        ->postOnProfile($final_message,
                                            $url,
                                            $blog->getTitle(),
                                            $blog->getShortContent());
                                }
                            }
                        }

                        $this->_getSession()->addSuccess(
                            $this->__('Total of %d record(s) were successfully posted on Facebook', count($blogIds))
                        );
                    } catch (Exception $e) {

                        $this->_getSession()->addError($e->getMessage());
                    }
                } else {
                    $this->_getSession()->addError(
                        $this->__('Please don\'t post over '. Mage::helper('deven_automation/facebook')->getArticlesLimitedNumber() .' articles!')
                    );
                }
            }
            $this->_redirect('*/*/index');
        }
    }
}
