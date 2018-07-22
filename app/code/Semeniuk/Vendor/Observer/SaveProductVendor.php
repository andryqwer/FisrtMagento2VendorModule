<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 23:29
 */

namespace Semeniuk\Vendor\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveProductVendor implements ObserverInterface
{
    /**
     * Catalog data
     *
     * @var \Magento\Catalog\Helper\Data
     */
    protected $catalogData;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Framework\App\ResourceConnection  $resource
     * @param \Magento\Framework\Registry                         $coreRegistry         [description]
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\Registry $coreRegistry
    )
    {
        $this->_resource = $resource;
        $this->_coreRegistry = $coreRegistry;
    }

    /**
     * Checking whether the using static urls in WYSIWYG allowed event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $connection = $this->_resource->getConnection();
        $table_name = $this->_resource->getTableName('semeniuk_vendor_product');
        $productController = $observer->getController();
        $productId = $productController->getRequest()->getParam('id');
        $data = $productController->getRequest()->getPostValue();

        $this->_coreRegistry->register('current_product_entity_for_vendor', $data);

        $is_saved_vendor = $this->_coreRegistry->registry('fired_save_action');
        if(!$is_saved_vendor) {
            if($productId) {
                $connection->query('DELETE FROM ' . $table_name . ' WHERE product_id =  ' . (int)$productId . ' ');
            }
            if(isset($data['product']['product_vendor']) && $productId){
                $productVendors = $data['product']['product_vendor'];
                if(!is_array($productVendors)){
                    $productVendors = array();
                    $productVendors[] = (int)$data['product']['product_vendor'];
                }
                foreach ($productVendors as $k => $v) {
                    if($v) {
                        $connection->query('INSERT INTO ' . $table_name . ' VALUES ( ' . $v . ', ' . (int)$productId . ')');
                    }
                }
                $this->_coreRegistry->register('fired_save_action', true);
            }
        }
    }
}