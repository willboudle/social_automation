<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/6/2015
 * Time: 9:11 PM
 */

class Deven_Automation_Model_Facebook_Status_Publisher extends Deven_Automation_Model_Facebook_Client {

    protected $accessToken;

    protected $pageAccessTokens;

    public function __construct()
    {
        $this->pages = Mage::getResourceSingleton('deven_automation/facebook_page_collection');

        $this->accessToken = Mage::getStoreConfig('automation/facebook/access_token');

        $this->setAccessToken($this->accessToken);
    }

    public function postLinkOnGroups($groups, $message, $url, $caption, $image, $name, $description)
    {
        foreach($groups as $key => $value) {
            $this->api("/$value/feed"
                , 'POST',
                array(
                    'message' => $message,
                    'link' => $url,
                    'caption'   => $caption,
                    'picture' => $image,
                    'name' => $name,
                    'description' => $description
                ));
        }
    }

    public function postLinkOnPages($message, $url, $caption, $image, $name, $description)
    {
        if($this->pages) {
            foreach($this->pages as $page) {
                if($page->getEnablePosting()==1) {
                    $this->setPageAccessToken($page->getAccessToken());
                    $this->postLinkOnProfile($message, $url, $caption, $image, $name, $description);
                }
            }
        }
    }

    public function postLinkOnProfile($message, $url, $caption, $image, $name, $description)
    {
        $this->api('/me/feed'
            , 'POST',
            array(
                'message' => $message,
                'link' => $url,
                'caption'   => $caption,
                'picture' => $image,
                'name' => $name,
                'description' => $description
            ));
    }



    public function postPhotoOnGroups($groups, $message, $image)
    {
        foreach($groups as $key => $value) {
            $this->api("/$value/photos", 'POST', array('caption' => $message, 'url' => $image));
        }
    }

    /*public function scheduledPostOnPages($message, $url, $image, $name, $shortDescription, $isPublished = false, $time)
    {
        if($this->pageAccessTokens) {
            foreach($this->pageAccessTokens as $pageToken) {
                $this->setAccessToken(json_encode($pageToken));
                $this->api('/me/feed', 'POST', array('message' => $message,
                    'link' => $url,
                    'picture' => $image,
                    'name' => $name,
                    'description' => $shortDescription,
                    'published' => $isPublished,
                    'scheduled_publish_time'    => $time
                ));
            }
        }
    }*/

    public function postPhotoOnPages($message, $image)
    {
        if($this->pages) {
            foreach($this->pages as $page) {
                if($page->getEnablePosting()==1) {
                    $this->setPageAccessToken($page->getAccessToken());
                    $this->postPhotoOnProfile($message, $image);
                }
            }
        }
    }

    /*public function scheduledPostPhotoOnPages($message, $image, $isPublished = false, $time)
    {
        if($this->pageAccessTokens) {
            foreach($this->pageAccessTokens as $pageToken) {
                $this->setAccessToken(json_encode($pageToken));
                $this->api('/me/photos', 'POST', array('caption' => $message,
                    'url' => $image,
                    'published' => $isPublished,
                    'scheduled_publish_time'    => $time
                ));
            }
        }
    }*/

    public function postPhotoOnProfile($message, $image)
    {
        $this->api('/me/photos', 'POST', array('caption' => $message,
            'url' => $image
        ));
    }

    public function postMessageOnProfile($message)
    {
        $this->api('/me/feed', 'POST', array('message' => $message));
    }

    public function postMessageOnGroups($groups, $message)
    {
        foreach($groups as $key => $value) {
            $this->api("/$value/feed", 'POST', array('message' => $message));
        }
    }

    public function postMessageOnPages($message)
    {
        if($this->pages) {
            foreach($this->pages as $page) {
                if($page->getEnablePosting()==1) {
                    $this->setPageAccessToken($page->getAccessToken());
                    $this->postMessageOnProfile($message);
                }
            }
        }
    }
} 