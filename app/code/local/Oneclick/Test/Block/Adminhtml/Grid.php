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
 * to test Adminhtml grid block
 *
 *
 * @category   Oggetto
 * @package    Oggetto_Oneclick
 * @subpackage Test
 * @since      Class available since module release 0.0.1
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */
class Oggetto_Oneclick_Test_Block_Adminhtml_Grid extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Test prepares collection for grid
     *
     * @return void
     */
    public function testPreparesCollection()
    {
        $blocks = $this->_prepareBlocks();
        $this->assertNotEquals($blocks[0]->getCollection(), $blocks[1]->getCollection());
    }

    /**
     * Test Prepares columns for grid
     *
     * @return void
     */
    public function testPreparesColumns()
    {
        $blocks = $this->_prepareBlocks();
        $this->assertNotEquals($blocks[0]->getColumns(), $blocks[1]->getColumns());
    }

    /**
     * Test Prepares Mass Action for Grid
     *
     * @return void
     */
    public function testPreparesMassAction()
    {
        $blocks = $this->_prepareBlocks();
        $this->assertNotEquals($blocks[0]->getMassactionIdField(), $blocks[1]->getMassactionIdField());
    }

    /**
     * Prepare mocks for blocks for tests
     *
     * @return array(Mage_Adminhtml_Block_Widget_Grid, Oggetto_Oneclick_Block_Adminhtml_Oneclick_Grid)
     */
    private function _prepareBlocks()
    {
        $parentBlock = $this->getBlockMock('adminhtml/widget_grid', ['getLayout']);
        $parentBlock->expects($this->any())
            ->method('getLayout')
            ->will($this->returnValue(new Mage_Core_Model_Layout()));

        $session = $this->getModelMock('core/session');
        $this->replaceByMock('singleton', 'core/session', $session);

        $block = $this->getBlockMock('oggetto_oneclick/adminhtml_oneclick_grid',
            ['getLayout', 'getGridUrl', 'getRowUrl', 'getParam']);
        $block->expects($this->any())
            ->method('getLayout')
            ->will($this->returnValue(new Mage_Core_Model_Layout()));
        $block->expects($this->any())
            ->method('getGridUrl')
            ->will($this->returnValue(''));
        $block->expects($this->any())
            ->method('getRowUrl')
            ->will($this->returnValue(''));
        $block->expects($this->any())
            ->method('getParam')
            ->will($this->returnValue(null));
        $parentBlock->getHtml();
        $block->getHtml();
        return [$parentBlock,$block];
    }
}
