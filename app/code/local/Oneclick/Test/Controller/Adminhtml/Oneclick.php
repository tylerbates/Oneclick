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
 * to test adminhtml controller
 *
 *
 * @category   Oggetto
 * @package    Oggetto_Oneclick
 * @subpackage Test
 * @since      Class available since module release 0.0.1
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */
class Oggetto_Oneclick_Test_Controller_Adminhtml_Oneclick extends Oggetto_Phpunit_Test_Case_Controller_Adminhtml
{
    /**
     * Setting up test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->_setUpAdminSession();
        $this->_disableIndexNotifications();
    }

    /**
     * test index action
     *
     * @return void
     */
    public function testIndexAction()
    {
        $this->dispatch('adminhtml/oneclick/index');
        $this->assertLayoutLoaded('oneclick');
        $this->assertLayoutBlockCreated('oneclick.grid.container');
        $this->assertLayoutBlockRendered('oneclick.grid.container');
        $this->assertLayoutRendered('oneclick');
    }

    /**
     * test grid action
     *
     * @return void
     */
    public function testGridAction()
    {
        $this->dispatch('adminhtml/oneclick/grid');
        $this->assertLayoutLoaded('oneclick');
        $this->assertLayoutRendered('oneclick');
    }

    /**
     * test view action
     *
     * @return void
     */
    public function testViewAction()
    {
        $model = $this->getModelMock('oggetto_oneclick/order', ['load']);
        $model->expects($this->once())
            ->method('load')
            ->with($this->equalTo(1))
            ->will($this->returnValue($model));
        $this->replaceByMock('model', 'oggetto_oneclick/order', $model);
        $this->getRequest()->setParam('id', 1);
        $this->dispatch('adminhtml/oneclick/view');
        $this->assertLayoutLoaded('oneclick');
        $this->assertLayoutRendered('oneclick');
        $this->assertEquals($model, Mage::registry('order'));
    }

    /**
     * Test delete Action
     *
     * @return void
     */
    public function testDeleteAction()
    {
        $model = $this->getModelMock('oggetto_oneclick/order', ['load', 'getId', 'delete']);
        $model->expects($this->once())
            ->method('load')
            ->with($this->equalTo(1))
            ->will($this->returnValue($model));
        $model->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(1));
        $model->expects($this->once())
            ->method('delete');
        $this->replaceByMock('model', 'oggetto_oneclick/order', $model);
        $this->getRequest()->setParam('id', 1);
        $this->dispatch('adminhtml/oneclick/delete');
        $this->assertRedirectToUrlContains('oneclick/index');
    }

    /**
     * test Mass Delete Action
     *
     * @return void
     */
    public function testMassDeleteAction()
    {
        $this->getRequest()->setParam('order', ["1", "2", "3"]);
        $model = $this->getModelMock('oggetto_oneclick/order', ['load', 'getId', 'delete']);
        $model->expects($this->exactly(3))
            ->method('load')
            ->will($this->returnValue($model));
        $model->expects($this->at(1))
            ->method('getId')
            ->will($this->returnValue(1));
        $model->expects($this->at(4))
            ->method('getId')
            ->will($this->returnValue(2));
        $model->expects($this->at(7))
            ->method('getId')
            ->will($this->returnValue(3));
        $model->expects($this->exactly(3))->method('delete');
        $this->replaceByMock('model', 'oggetto_oneclick/order', $model);
        $this->dispatch('adminhtml/oneclick/massDelete');
        $this->assertRedirectToUrlContains('oneclick/index');
    }

    /**
     * test Order Action
     *
     * @return void
     */
    public function testOrderAction()
    {
        $this->getRequest()->setParam('id', 1);
        $model = $this->getModelMock('oggetto_oneclick/order', ['load', 'createOrder']);
        $model->expects($this->once())
            ->method('load')
            ->will($this->returnValue($model));
        $model->expects($this->once())
            ->method('createOrder');
        $this->replaceByMock('model', 'oggetto_oneclick/order', $model);
        $this->dispatch('adminhtml/oneclick/order');
        $this->assertRedirectToUrlContains('/sales_order_edit');
    }
}