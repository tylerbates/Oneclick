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
 * Extend default Magento Adminhtml Controller
 * to add admin grid and actions for one click orders
 *
 * @category   Oggetto
 * @package    Oggetto_Oneclick
 * @subpackage controllers
 * @since      Class available since module release 0.0.1
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Oneclick_Adminhtml_OneclickController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Entry point
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_title($this->__('Oneclick Orders'))
            ->_title($this->__('Manage oneclick orders'));
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Grid render action
     *
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Delete order action
     *
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                /** @var $model Oggetto_Oneclick_Model_Order */
                $model = Mage::getModel('oggetto_oneclick/order');
                $model->load($id);

                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('oggetto_oneclick')->__('Unable to find order item.'));
                }

                $model->delete();

                $this->_getSession()->addSuccess(
                    Mage::helper('oggetto_oneclick')->__('Order item has been deleted.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('oggetto_oneclick')->__('An error occurred while deleting order item.')
                );
            }
        }

        $this->_redirect('*/*/');
    }

    /**
     * Order create action
     *
     * @return void
     */
    public function orderAction()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var $order Oggetto_Oneclick_Model_Order*/
        $order = Mage::getModel('oggetto_oneclick/order')->load($id);
        $order->createOrder();
        $this->_redirect('*/sales_order_edit');
    }

    /**
     * Mass delete action
     *
     * @return void
     */
    public function massDeleteAction()
    {
        $ids = (array) $this->getRequest()->getParam('order');
        $success = true;
        foreach ($ids as $id) {
            try {
                /** @var $model Oggetto_Oneclick_Model_Order */
                $model = Mage::getModel('oggetto_oneclick/order');
                $model->load($id);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('oggetto_oneclick')->__('Unable to find order item.'));
                }

                $model->delete();
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $success = false;
            } catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('oggetto_oneclick')->__('An error occurred while deleting order items.')
                );
                $success = false;
            }
        }
        if ($success) {
            $this->_getSession()->addSuccess(
                Mage::helper('oggetto_oneclick')->__('Order items have been deleted.')
            );
        }
        $this->_redirect('*/*/');
    }

    /**
     * Order details view action
     *
     * @return void
     */
    public function viewAction()
    {
        $this->loadLayout();
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('oggetto_oneclick/order')->load($id);
        Mage::register('order', $model);
        $this->renderLayout();
    }
}
