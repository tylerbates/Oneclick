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
 * Extend magento abstract core model
 * to add order model
 *
 *
 * @category   Oggetto
 * @package    Oggetto_Oneclick
 * @subpackage Model
 * @since      Class available since module release 0.0.1
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 *
 * @method string getOrderId() get order id
 * @method string getCustomerName() get customer name
 * @method string getCustomerPhone() get customer phone
 * @method string getProductSku() get product sku
 * @method string getProductName() get product name
 * @method string getQty() get product quantity
 * @method string getStoreId() get store id
 */
class Oggetto_Oneclick_Model_Order extends Mage_Core_Model_Abstract
{
    /**
     * Model constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('oggetto_oneclick/order');
    }

    /**
     * Get customer by order info if it is registered
     *
     * @return Mage_Customer_Model_Customer|false
     */
    protected function _getCustomerIfExists()
    {
        $phone = substr($this->getData('customer_phone'), 2);
        $lastName = substr($this->getData('customer_name'), strpos($this->getData('customer_name'), ' ') + 1);
        $firstName = substr($this->getData('customer_name'), 0, strpos($this->getData('customer_name'), ' '));
        $customer = Mage::getModel('customer/customer')
            ->getCollection()
            ->addAttributeToSelect('oc_telephone')
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('lastname')
            ->addAttributeToFilter('oc_telephone', $phone)
            ->addAttributeToFilter('firstname', $firstName)
            ->addAttributeToFilter('lastname', $lastName)
            ->load()
            ->getItems();
        if (count($customer)) {
            return [
                'customer' => array_shift($customer),
                'first_name' => $firstName,
                'last_name' => $lastName
            ];
        } else {
            return [
                'customer' => false,
                'first_name' => $firstName,
                'last_name' => $lastName
            ];
        }
    }

    /**
     * Order Creation
     *
     * @return Mage_Sales_Model_Order
     */
    public function createOrder()
    {
        $customer = $this->_getCustomerIfExists()['customer'];

        $firstName = $this->_getCustomerIfExists()['first_name'];
        $lastName = $this->_getCustomerIfExists()['last_name'];
        $qty = $this->getData('qty');
        $productId = Mage::getModel('catalog/product')->getIdBySku($this->getData('product_sku'));
        $product = Mage::getModel('catalog/product')->load($productId);

        /** @var $quote Mage_Sales_Model_Quote */
        $quote = Mage::getModel('sales/quote');
        if ($customer) {
            $quote->assignCustomer($customer);
            $address = array_shift($customer->getAddresses());
            $quote->setBillingAddress($address);
            $quote->setShippingAddress($address);
        } else {
            $quote->setIsMultiShipping(false);
            $quote->setCheckoutMethod('guest');
            $quote->setCustomerId(false);
            $quote->setCustomerIsGuest(true);
            $quote->setCustomerGroupId(Mage_Customer_Model_Group::NOT_LOGGED_IN_ID);
            $quote->getShippingAddress()->setData('firstname', $firstName);
            $quote->getShippingAddress()->setData('lastname', $lastName);
            $quote->getBillingAddress()->setData('firstname', $firstName);
            $quote->getBillingAddress()->setData('lastname', $lastName);
        }
        $quote->setStoreId($this->getData('store_id'));

        $quote->addProduct($product, $qty);

        $quote->getShippingAddress()->setCollectShippingRates(true);
        $quote->getShippingAddress()->collectShippingRates();
        $quote->collectTotals();
        $quote->save();

        $quote->reserveOrderId();

        Mage::getSingleton('adminhtml/session_quote')
            ->clear()
            ->setQuoteId($quote->getId())
            ->setCustomerId($quote->getCustomerId())
            ->setStoreId($quote->getStoreId());
        return $quote;
    }
}
