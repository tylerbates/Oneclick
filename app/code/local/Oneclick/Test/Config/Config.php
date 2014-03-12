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
 * Extend Ecomdev Phpunit Config Test Case
 * to test module config
 *
 *
 * @category   Oggetto
 * @package    Oggetto_Oneclick
 * @subpackage Test
 * @since      Class available since module release 0.0.1
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */
class Oggetto_Oneclick_Test_Config_Config extends EcomDev_PHPUnit_Test_Case_Config
{
    /**
     * Test Module Config
     *
     * @return void
     */
    public function testModuleConfig()
    {
        $this->assertModuleVersion('0.0.1');
        $this->assertModuleCodePool('local');
    }

    /**
     * Test class Aliases
     *
     * @return void
     */
    public function testClassAliases()
    {
        $this->assertBlockAlias('oggetto_oneclick/form', 'Oggetto_Oneclick_Block_Form');
        $this->assertHelperAlias('oggetto_oneclick/data', 'Oggetto_Oneclick_Helper_Data');
    }

    /**
     * Test Layout files
     *
     * @return void
     */
    public function testLayoutFiles()
    {
        $this->assertLayoutFileDefined('frontend', 'oggetto_questions.xml', 'oggetto_questions');
        $this->assertLayoutFileExists('frontend', 'oggetto_questions.xml');
    }
}
