<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 23:38
 */
namespace Semeniuk\Vendor\Observer;

use Magento\Framework\Event\ObserverInterface;

class LoadProductVendor implements ObserverInterface
{
    /**
     * Catalog data
     *
     * @var \Magento\Catalog\Helper\Data
     */
    protected $catalogData;

    /**
     * @param \Magento\Catalog\Helper\Data $catalogData
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    )
    {
        $this->_resource = $resource;
    }

    /**
     * Checking whether the using static urls in WYSIWYG allowed event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $connection = $this->_resource->getConnection();
        $table_name = $this->_resource->getTableName('semeniuk_vendor_product');
        if($product->getId()) {
            $productIds = $connection->fetchCol(" SELECT vendor_id FROM ".$table_name." WHERE product_id = ".$product->getId());
            $product->setData('product_vendor', implode($productIds, ','));
        }

    }
}