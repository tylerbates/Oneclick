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
 * to test order model
 *
 *
 * @category   Oggetto
 * @package    Oggetto_Oneclick
 * @subpackage Test
 * @since      Class available since module release 0.0.1
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */
class Oggetto_Oneclick_Test_Model_Order extends EcomDev_PHPUnit_Test_Case
{
    /**
     * test puts quote into session
     *
     * @return void
     */
    public function testPutsQuoteIntoSession()
    {
        $order = $this->getModelMock('oggetto_oneclick/order', ['_getCustomerIfExists']);
        $order->expects($this->any())
            ->method('_getCustomerIfExists')
            ->will($this->returnValue([
                'customer' => false,
                'first_name' => 'someone',
                'last_name' => 'unexpectable'
            ]));

        $address = $this->getModelMock('sales/quote_address', ['collectShippingRates']);
        $address->expects($this->once())
            ->method('collectShippingRates');
        $this->replaceByMock('model', 'sales/quote_address', $address);

        $quote = $this->getModelMock('sales/quote', [
            'getId',
            'getCustomerId',
            'getStoreId',
            'addProduct',
            'getShippingAddress',
            'collectTotals',
            'save'
        ]);
        $quote->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(1));
        $quote->expects($this->any())
            ->method('getCustomerId')
            ->will($this->returnValue(null));
        $quote->expects($this->any())
            ->method('getStoreId')
            ->will($this->returnValue(1));
        $quote->expects($this->once())
            ->method('addProduct');
        $quote->expects($this->any())
            ->method('getShippingAddress')
            ->will($this->returnValue($address));
        $quote->expects($this->any())
            ->method('collectTotals');
        $quote->expects($this->any())
            ->method('save');
        $this->replaceByMock('model', 'sales/quote', $quote);

        $product = $this->getModelMock('catalog/product', ['load']);
        $product->expects($this->any())
            ->method('load')
            ->will($this->returnValue($product));
        $this->replaceByMock('model', 'catalog/product', $product);

        $sessionQuote = $this->getModelMockBuilder('adminhtml/session_quote')
            ->disableOriginalConstructor()
            ->setMethods(['clear', 'setQuoteId', 'setCustomerId', 'setStoreId'])
            ->getMock();
        $sessionQuote->expects($this->any())
            ->method('clear')
            ->will($this->returnSelf());
        $sessionQuote->expects($this->once())
            ->method('setQuoteId')
            ->will($this->returnSelf());
        $sessionQuote->expects($this->once())
            ->method('setCustomerId')
            ->will($this->returnSelf());
        $sessionQuote->expects($this->once())
            ->method('setStoreId')
            ->will($this->returnSelf());
        $this->replaceByMock('singleton', 'adminhtml/session_quote', $sessionQuote);

        $session = $this->getModelMockBuilder('core/session')
            ->disableOriginalConstructor()
            ->getMock();
        $this->replaceByMock('singleton', 'core/session', $session);

        $cookie = $this->getModelMockBuilder('core/cookie')
            ->disableOriginalConstructor()
            ->getMock();
        $this->replaceByMock('singleton', 'core/cookie', $cookie);

        $order->createOrder();
    }
}
