<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/6/2015
 * Time: 9:11 PM
 */

class Deven_Automation_Model_Facebook_Blog_Publisher extends Deven_Automation_Model_Facebook_Client {

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

    public function postOnGroups($message, $url, $name, $shortDescription)
    {
        foreach($this->groups as $group) {
            if($group->getEnablePosting()==1) {
                $this->api('/' . $group->getGroupId() . '/feed'
                    , 'POST',
                    array(
                        'message' => $message,
                        'link' => $url,
                        'name' => Mage::helper('blog')->stripTags($name),
                        'description' => Mage::helper('blog')->stripTags($shortDescription)
                    ));

            }
        }
    }

    public function postOnPages($message, $url, $name, $shortDescription)
    {
        if($this->pages) {
            foreach($this->pages as $page) {
                if($page->getEnablePosting()==1) {
                    $this->setPageAccessToken($page->getAccessToken());
                    $this->postOnProfile($message, $url, $name, $shortDescription);
                }
            }
        }
    }

    public function postOnProfile($message, $url, $name, $shortDescription)
    {
        $this->api('/me/feed', 'POST', array('message' => $message,
            'link' => $url,
            'name' => Mage::helper('blog')->stripTags($name),
            'description' => Mage::helper('blog')->stripTags($shortDescription)
        ));
    }
} 