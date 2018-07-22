<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 22.07.2018 23:03
 */

namespace Semeniuk\Vendor\Block\Product;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    /**
     *  Group Collection
     */
    protected $_vendorCollection;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    public function __construct(
        Context $context,
        PostHelper $postDataHelper,
        Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        Data $urlHelper,
        array $data = [])
    {
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
    }


    public function getVendorCollection($product)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');

        $this->_resource = $resource;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $collectionVendor = $objectManager->get('\Semeniuk\Vendor\Model\Vendor');
        $this->_vendorCollection = $collectionVendor;

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