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
 * Extend magento front controller
 * to add front controller
 *
 *
 * @category   Oggetto
 * @package    Oggetto_Oneclick
 * @subpackage controllers
 * @since      Class available since module release 0.0.1
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Oneclick_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * index action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        /**
         * @var $block Oggetto_Oneclick_Block_Form
         */

        $block = $this->getLayout()->getBlock('oneclick.form');
        $block->registerProduct($this->_getProduct());
        $block->registerCustomerInfo($this->_getCustomer());
        $block->registerBackUrl($this->_getLastUrl());
        $this->renderLayout();
    }

    /**
     * Order processing action
     *
     * @return void
     */
    public function orderAction()
    {
        $post = $this->getRequest()->getPost();
        $order = Mage::getModel('oggetto_oneclick/order');
        $backUrl = array_shift($post);
        $post['customer_phone'] = '+7' . $post['customer_phone'];
        $order->setData($post);
        $order->save();

        if ($order->getId()) {
            Mage::getSingleton('core/session')->addSuccess(
                $this->__('Your order is in queue now. Just wait for a call')
            );
        } else {
            Mage::getSingleton('core/session')->addError(
                $this->__('There were some errors try one more time')
            );
        }

        $this->_redirect($backUrl);
    }

    /**
     * Get Last Used url
     *
     * @return string
     */
    protected function _getLastUrl()
    {
        return Mage::getSingleton('core/session')->getLastUrl();
    }

    /**
     * Get Customer from Session
     *
     * @return Mage_Customer_Model_Customer|false
     */
    protected function _getCustomer()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn() ?
            Mage::getSingleton('customer/session')->getCustomer() : false;
    }

    /**
     * Get Product from url params
     *
     * @return Mage_Catalog_Model_Product|false
     */
    protected function _getProduct()
    {
        $post = $this->getRequest()->getPost();
        if ($this->getRequest()->getPost()['product']) {
            /** @var $product Mage_Catalog_Model_Product*/
            $product = Mage::getModel('catalog/product')->load($post['product']);
            if ($product->isConfigurable()) {
                $childProduct = Mage::getModel('catalog/product_type_configurable')
                    ->getProductByAttributes($this->getRequest()->getPost('super_attribute'), $product);
                return $childProduct;
            } else {
                return $product;
            }
        } return false;
    }
}
