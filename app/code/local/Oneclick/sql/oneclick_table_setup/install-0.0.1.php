<?php
/**
 * Oggetto one click orders extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Oneclick module to newer versions in the future.
 * If you wish to customize the Oggetto Oneclick module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Oneclick
 * @copyright  Copyright (C) 2011 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @var $installer Oggetto_Oneclick_Model_Order_Setup
 */

$installer = $this;

$table = $installer->getConnection()
    ->newTable($installer->getTable('oggetto_oneclick/orders'))
    ->addColumn(
        'order_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned' => true,
            'identity' => true,
            'nullable' => false,
            'primary' => true,
        ),
        'Entity id')
    ->addColumn(
        'customer_name',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        63,
        array('nullable' => true),
        'Customer name')
    ->addColumn(
        'customer_phone',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        63,
        array('nullable' => true),
        'Customer telephone')
    ->addColumn(
        'product_sku',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        63,
        array('nullable' => true),
        'Product SKU')
    ->addColumn(
        'product_name',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        63,
        array('nullable' => true),
        'Product name')
    ->addColumn(
        'qty',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'default' => 1,
            'nullable' => false,
            'unsigned' => true
        ),
        'Product quantity')
    ->addColumn(
        'store_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'default' => 1,
            'nullable' => false,
            'unsigned' => true
        ),
        'Store Id'
    )
    ->setComment('Oneclick order item');
$installer->getConnection()->createTable($table);
