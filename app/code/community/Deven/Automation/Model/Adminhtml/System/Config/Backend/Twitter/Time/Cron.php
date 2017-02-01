<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 10/28/2015
 * Time: 1:25 PM
 */

class Deven_Automation_Model_Adminhtml_System_Config_Backend_Twitter_Time_Cron extends Mage_Core_Model_Config_Data
{
    const CRON_STRING_PATH = 'crontab/jobs/autotweet/schedule/cron_expr';

    protected function _afterSave()
    {
        $time = $this->getData('groups/twitter/fields/tweet_every_time/value');

        $isPostFrequency = $this->getData('groups/twitter/fields/update_tweet_at_time_frequency/value');

        if(!$isPostFrequency) {

            try {
                Mage::getModel('core/config_data')
                    ->load(self::CRON_STRING_PATH, 'path')
                    ->setValue($time)
                    ->setPath(self::CRON_STRING_PATH)
                    ->save();
            }
            catch (Exception $e) {
                throw new Exception(Mage::helper('cron')->__('Unable to save the cron expression.'));
            }
        }
    }
}