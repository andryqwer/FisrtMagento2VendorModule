<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 23:14
 */

namespace Semeniuk\Vendor\Block\Product;

class View extends \Magento\Framework\View\Element\Template
{
    /**
     * Group Collection
     */
    protected $_vendorCollection;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry                      $registry
     * @param \Semeniuk\Vendor\Model\Vendor                    $vendorCollection
     * @param array                                            $data
     */

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Semeniuk\Vendor\Model\Vendor $vendorCollection,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
    ) {
        $this->_vendorCollection = $vendorCollection;
        $this->_coreRegistry = $registry;
        $this->_resource = $resource;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve current product model
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->_coreRegistry->registry('current_product');
    }

    public function getVendorCollection()
    {
        $product = $this->getProduct();

        $connection = $this->_resource->getConnection();
        $table_name = $this->_resource->getTableName('semeniuk_vendor_product');
        $vendorIds = $connection->fetchCol(" SELECT vendor_id FROM ".$table_name." WHERE product_id = ".$product->getId());
        if($vendorIds || count($vendorIds) > 0) {
            $collection = $this->_vendorCollection->getCollection()
                ->setOrder('vendor_id','ASC');
            $collection->getSelect()->where('vendor_id IN (?)', $vendorIds);

            return $collection;
        }
        return false;
    }
}