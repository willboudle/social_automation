<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 11/3/2015
 * Time: 10:52 AM
 */

class Deven_Automation_Model_Adminhtml_System_Config_Source_Catalog_Product_Visibility extends Mage_Catalog_Model_Product_Visibility {

    public function toOptionArray()
    {
        return parent::getAllOptions();
    }
} 