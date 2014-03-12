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
 * Extend magento adminhtml grid template
 * to add adminhtml grid
 *
 *
 * @category   Oggetto
 * @package    Oggetto_Oneclick
 * @subpackage Block
 * @since      Class available since module release 0.0.1
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */
class Oggetto_Oneclick_Block_Adminhtml_Oneclick_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Init widget block
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('oneclick_orders_list_grid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Get resource collection for grid
     *
     * @return Oggetto_Oneclick_Block_Adminhtml_Oneclick_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('oggetto_oneclick/order')->getResourceCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Add questions delete mass action
     *
     * @return object
     */
    protected function _prepareMassAction()
    {
        parent::_prepareMassaction();
        $this->setMassactionIdField('customer_name');
        $this->getMassactionBlock()->setFormFieldName('order');
        $this->getMassactionBlock()->addItem('oggetto_oneclick', array(
                'label' => Mage::helper('oggetto_oneclick')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('oggetto_oneclick')->__('Are you sure?')
            )
        );
    }

    /**
     * Prepare Grid columns
     *
     * @return Mage_Adminhtml_Block_Catalog_Search_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('customer_name', array(
            'header' => Mage::helper('oggetto_oneclick')->__('Customer name'),
            'index' => 'customer_name'
        ));
        $this->addColumn('customer_phone', array(
            'header' => Mage::helper('oggetto_oneclick')->__('Customer telephone'),
            'index' => 'customer_phone'
        ));
        $this->addColumn('product_sku', array(
            'header' => Mage::helper('oggetto_oneclick')->__('Product SKU'),
            'index' => 'product_sku'
        ));
        $this->addColumn('product_name', array(
            'header' => Mage::helper('oggetto_oneclick')->__('Product name'),
            'index' => 'product_name'
        ));
        $this->addColumn('action', array(
            'header' => Mage::helper('oggetto_oneclick')->__('Action'),
            'type' => 'action',
            'sortable' => false,
            'filter' => false,
            'index' => 'orders',
            'getter'    => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('oggetto_oneclick')->__('Delete'),
                    'url' => array('base' => '*/*/delete'),
                    'field' => 'id',
                    'confirm' => Mage::helper('oggetto_oneclick')->__('Are you sure?')
                ),
                array(
                    'caption' => Mage::helper('oggetto_oneclick')->__('Create Order'),
                    'url' => array('base' => '*/*/order'),
                    'field' => 'id'
                )
            )
        ));

        return parent::_prepareColumns();
    }

    /**
     * Get url for grid row
     *
     * @param Varien_Object $row Row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/view', array('id' => $row->getId()));
    }

    /**
     * Grid url getter
     *
     * @return string current grid url
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}
