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
 * Extend Ecomdev Phpunit Controller Test Case
 * to test front controller
 *
 *
 * @category   Oggetto
 * @package    Oggetto_Oneclick
 * @subpackage Test
 * @since      Class available since module release 0.0.1
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */
class Oggetto_Oneclick_Test_Controller_Index extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * Test Index Action
     *
     * @return void
     */
    public function testIndexAction()
    {
        $this->getRequest()->setPost(['product' => 27, 'super_attribute' => [1 => 2], 'qty' => '2']);

        $this->dispatch('oneclick/index/index');
        $this->assertLayoutLoaded('oneclick');
        $this->assertLayoutBlockCreated('oneclick.form');
        $this->assertLayoutBlockRendered('oneclick.form');
        $this->assertLayoutRendered('oneclick');
    }

    /**
     * Test Order action
     *
     * @return void
     */
    public function testOrderAction()
    {
        $oldOrder = Mage::getModel('oggetto_oneclick/order')->getCollection()->toArray();
        $this->getRequest()->setPost([
            'back_url' => '123321',
            'customer_phone' => '',
            'customer_name' => '',
            'product_sku' => '',
            'product_name' => '',
            'qty' => '1'
        ]);
        $this->dispatch('oneclick/index/order');
        $newOrder = Mage::getModel('oggetto_oneclick/order')->getCollection()->toArray();
        $burl = Mage::getBaseUrl();
        $this->assertRedirectToUrl($burl . '123321/');
        $this->assertNotEquals($oldOrder, $newOrder);
    }
}
