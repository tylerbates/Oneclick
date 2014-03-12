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
 * Extend Ecomdev Phpunit Test Case
 * to test front form block
 *
 *
 * @category   Oggetto
 * @package    Oggetto_Oneclick
 * @subpackage Test
 * @since      Class available since module release 0.0.1
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */
class Oggetto_Oneclick_Test_Block_Form extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Test retrieves product from params
     *
     * @test
     * @loadFixture
     * @return void
     */
    public function testRetrievesProductFromParams()
    {
        $product = Mage::getModel('catalog/product');
        $block = new Oggetto_Oneclick_Block_Form();
        $block->registerProduct($product);
        $this->assertEquals($product, Mage::registry('product'));
    }

    /**
     * Test retrieves customer name and telephone
     *
     * @return void
     */
    public function testRetrievesCustomerNameAndTelephone()
    {
        $customer = new Mage_Customer_Model_Customer();
        $customer->setData('firstname', 'something');
        $customer->setData('lastname', 'unexpectable');
        $customer->setData('oc_telephone', '111');

        $block = new Oggetto_Oneclick_Block_Form();

        $block->registerCustomerInfo($customer);
        $this->assertEquals('something unexpectable', Mage::registry('customer_name'));
        $this->assertEquals('111', Mage::registry('customer_phone'));
    }

    /**
     * Test Retrieves Back url
     *
     * @return void
     */
    public function testRetrievesBackUrl()
    {
        $block = new Oggetto_Oneclick_Block_Form();
        $block->registerBackUrl('http://127.0.1.1/module.myserver/index.php/catalog/product/view/id/27/');
        $this->assertEquals('catalog/product/view/id/27/', Mage::registry('back_url'));
    }
}
