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
 * Extend magento core block template
 * to add front form block
 *
 *
 * @category   Oggetto
 * @package    Oggetto_Oneclick
 * @subpackage Block
 * @since      Class available since module release 0.0.2
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Oneclick_Block_Form extends Mage_Core_Block_Template
{
    /**
     * Get Product info
     *
     * @param Mage_Catalog_Model_Product $product got product
     * @return mixed
     */
    public function registerProduct($product)
    {
        if (!Mage::registry('product') && $product) {
            Mage::register('product', $product);
        }
    }

    /**
     * Get Customer Info
     *
     * @param Mage_Customer_Model_Customer $customer got customer
     * @return void
     */
    public function registerCustomerInfo($customer)
    {
        /**
         * @var $customer Mage_Customer_Model_Customer
         */
        if ($customer) {
            $telephone = $customer->getData('oc_telephone');
            $name = $customer->getName();
            Mage::register('customer_name', $name);
            Mage::register('customer_phone', $telephone);
        }
    }

    /**
     * Get Back Url
     *
     * @param string $url got last url
     * @return void
     */
    public function registerBackUrl($url)
    {
        if (!Mage::registry('back_url')) {
            $backUrl = substr($url, strpos($url, 'catalog'));
            Mage::register('back_url', $backUrl);
        }
    }
}
