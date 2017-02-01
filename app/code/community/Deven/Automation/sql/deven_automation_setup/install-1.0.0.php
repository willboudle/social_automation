<?php
/**
 * Created by PhpStorm.
 * User: jimmyhien
 * Date: 3/29/2016
 * Time: 1:57 PM
 */

$installer = $this;

$installer->startSetup();

$facebookGroupTable = $installer->getTable('deven_automation/facebook_group');
$facebookPageTable = $installer->getTable('deven_automation/facebook_page');
$pinterestBoardTable = $installer->getTable('deven_automation/pinterest_board');

if($installer->getConnection()->isTableExists($pinterestBoardTable) != true)
{
    $table = $installer->getConnection()
        ->newTable($pinterestBoardTable)
        ->addColumn('id',
            Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ), 'ID')
        ->addColumn('board_id',
            Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array(), 'Board Id')
        ->addColumn('name',
            Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array(), 'Board Name')
        ->addColumn('url',
            Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array(), 'Board Url')
        ->addColumn('description',
            Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Board Description')
        ->addColumn('enable_pinning', Varien_Db_Ddl_Table::TYPE_TINYINT, null, null, 'Enable Pinning');

    $installer->getConnection()->createTable($table);
}

if($installer->getConnection()->isTableExists($facebookGroupTable) != true)
{
    $table = $installer->getConnection()
        ->newTable($facebookGroupTable)
        ->addColumn('id',
            Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ), 'ID')
        ->addColumn('group_id',
            Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array(), 'Group Id')
        ->addColumn('name',
            Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array(), 'Group Name')
        ->addColumn('description',
            Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Group Description')
        ->addColumn('enable_posting', Varien_Db_Ddl_Table::TYPE_TINYINT, null, null, 'Enable Posting');

    $installer->getConnection()->createTable($table);
}

if($installer->getConnection()->isTableExists($facebookPageTable) != true)
{
    $table = $installer->getConnection()
        ->newTable($facebookPageTable)
        ->addColumn('id',
            Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ), 'ID')
        ->addColumn('page_id',
            Varien_Db_Ddl_Table::TYPE_TEXT, null,
            array(), 'Page Id')
        ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array(), 'Page Name')
        ->addColumn('category', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array(), 'Page Category')
        ->addColumn('access_token', Varien_Db_Ddl_Table::TYPE_TEXT, null,
            array(), 'Page Access Token')
        ->addColumn('enable_posting', Varien_Db_Ddl_Table::TYPE_TINYINT, null, null, 'Enable Posting');
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();
