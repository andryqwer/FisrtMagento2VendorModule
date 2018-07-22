<?php
namespace Semeniuk\Vendor\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveProductVendorModel implements ObserverInterface
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
        $_product = $observer->getProduct();  // you will get product object
        $productId = $_product->getId();
        $is_saved_vendor = $this->_coreRegistry->registry('fired_save_action');
        if(!$is_saved_vendor) {
            $data = $this->_request->getPost();;
            if($productId) {
                $connection->query('DELETE FROM ' . $table_name . ' WHERE product_id =  ' . (int)$productId . ' ');
            }
            if($data && isset($data['product']['product_vendor']) && $productId){
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
            }
            $this->_coreRegistry->register('fired_save_action', true);
        }
    }
}
