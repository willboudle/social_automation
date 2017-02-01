<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/6/2015
 * Time: 9:11 PM
 */

class Deven_Automation_Model_Facebook_Product_Publisher extends Deven_Automation_Model_Facebook_Client {

    protected $groups;

    protected $accessToken;

    protected $pageAccessTokens;

    public function __construct()
    {
        $this->groups = Mage::getResourceSingleton('deven_automation/facebook_group_collection');

        $this->pages = Mage::getResourceSingleton('deven_automation/facebook_page_collection');

        $this->accessToken = Mage::getStoreConfig('automation/facebook/access_token');

        $this->setAccessToken($this->accessToken);
    }

    public function postOnGroups($message, $url, $image, $name, $shortDescription)
    {
        foreach($this->groups as $group) {
            if($group->getEnablePosting()==1) {
                $this->api('/' . $group->getGroupId() . '/feed'
                    , 'POST',
                    array(
                        'message' => $message,
                        'link' => $url,
                        'picture' => $image,
                        'name' => Mage::helper('deven_automation')->stripTags($name),
                        'description' => Mage::helper('deven_automation')->stripTags($shortDescription)
                    ));

            }
        }
    }

    public function postPhotoOnGroups($message, $image)
    {
        foreach($this->groups as $group) {
            if($group->getEnablePosting()==1) {
                $this->api('/' . $group->getGroupId() . '/photos', 'POST', array('caption' => $message, 'url' => $image));
            }
        }
    }

    public function postOnPages($message, $url, $image, $name, $shortDescription)
    {
        if($this->pages) {
            foreach($this->pages as $page) {
                if($page->getEnablePosting()==1) {
                    $this->setPageAccessToken($page->getAccessToken());
                    $this->postOnProfile($message, $url, $image, Mage::helper('deven_automation')->stripTags($name), Mage::helper('deven_automation')->stripTags($shortDescription));
                }
            }
        }
    }

    public function scheduledPostOnPages($message, $url, $image, $name, $shortDescription, $isPublished = false, $time)
    {
        if($this->pages) {
            foreach($this->pages as $page) {
                if($page->getEnablePosting()==1) {
                    $this->setPageAccessToken($page->getAccessToken());
                    $this->api('/me/feed', 'POST', array('message' => $message,
                        'link' => $url,
                        'picture' => $image,
                        'name' => Mage::helper('deven_automation')->stripTags($name),
                        'description' => Mage::helper('deven_automation')->stripTags($shortDescription),
                        'published' => $isPublished,
                        'scheduled_publish_time' => $time
                    ));
                }
            }
        }
    }

    public function postPhotoOnPages($message, $image)
    {
        if($this->pages) {
            foreach($this->pages as $page) {
                if($page->getEnablePosting()==1) {
                    $this->setPageAccessToken($page->getAccessToken());
                    $this->api('/me/photos', 'POST', array('caption' => $message,
                        'url' => $image
                    ));
                }
            }
        }
    }

    public function scheduledPostPhotoOnPages($message, $image, $isPublished = false, $time)
    {
        if($this->pages) {
            foreach($this->pages as $page) {
                if($page->getEnablePosting()==1) {
                    $this->setPageAccessToken($page->getAccessToken());
                    $this->api('/me/photos', 'POST', array('caption' => $message,
                        'url' => $image,
                        'published' => $isPublished,
                        'scheduled_publish_time' => $time
                    ));
                }
            }
        }
    }

    public function postOnProfile($message, $url, $image, $name, $shortDescription)
    {
        $this->api('/me/feed', 'POST', array('message' => $message,
            'link' => $url,
            'picture' => $image,
            'name' => Mage::helper('deven_automation')->stripTags($name),
            'description' => Mage::helper('deven_automation')->stripTags($shortDescription)
        ));
    }

    public function postPhotoOnProfile($message, $image)
    {
        $this->api('/me/photos', 'POST', array('caption' => $message,
            'url' => $image
        ));
    }

    public function postStatusOnGroups($groups, $message)
    {
        foreach($groups as $group) {
            if($group->getEnablePosting()==1) {
                $this->api('/' . $group->getGroupId() . '/feed'
                    , 'POST',
                    array('message' => $message));
            }
        }
    }
} 