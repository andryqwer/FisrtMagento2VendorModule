<?php

namespace Semeniuk\Vendor\Observer;

use Magento\Framework\Event\ObserverInterface;

class MassUpdateAttributeVendorModel implements ObserverInterface
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
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

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
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\RequestInterface $request
        )
    {
        $this->_resource = $resource;
        $this->_coreRegistry = $coreRegistry;
        $this->_request = $request;
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
        $_product_ids = $observer->getData("product_ids");  // you will get product ids
        $is_saved_vendor = $this->_coreRegistry->registry('fired_save_action');
        if(!$is_saved_vendor) {
            $data = $observer->getData("attributes_data");
            if($_product_ids) {
                $connection->query('DELETE FROM ' . $table_name . ' WHERE product_id in (' . implode(",", $_product_ids) . ')');
            }
            if($data && isset($data['product_vendor']) && $_product_ids){
                $productVendors = $data['product_vendor'];
                if(!is_array($productVendors)){
                    $productVendors = array();
                    $productVendors[] = (int)$data['product_vendor'];
                }
                foreach ($productVendors as $k => $v) {
                    if($v) {
                        foreach($_product_ids as $productId) {
                            $connection->query('INSERT INTO ' . $table_name . ' VALUES ( ' . $v . ', ' . (int)$productId . ')');
                        }
                        
                    }
                }
            }
            $this->_coreRegistry->register('fired_save_action', true);
        }
    }
}
