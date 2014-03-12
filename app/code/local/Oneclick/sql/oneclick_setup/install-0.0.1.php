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
 * @var $installer Oggetto_Oneclick_Model_Entity_Setup
 */
$installer = $this;

$installer->startSetup();

$entity = $installer->getEntityTypeId('customer');

$installer->addAttribute($entity, 'oc_telephone', [
    'entity_type_id' => $entity,
    'type'       => 'text',
    'label'      => 'Contact telephone',
    'input'      => 'text',
    'global'     => 1,
    'visible' => 1,
    'user_defined' => 1,
    'default' => '0',
    'required'   => 0,
    'visible_on_front' => 1,

]);

$attribute = Mage::getSingleton('eav/config')
    ->getAttribute($installer->getEntityTypeId('customer'), 'oc_telephone');
$attribute->setData('used_in_forms', ['customer_account_edit', 'customer_account_create', 'adminhtml_customer']);
$attribute->save();

$installer->endSetup();
