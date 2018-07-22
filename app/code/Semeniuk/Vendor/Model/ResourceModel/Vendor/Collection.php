<?php

namespace Semeniuk\Vendor\Model\ResourceModel\Vendor;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'vendor_id';
    protected $_eventPrefix = 'semeniuk_vendor_collection';
    protected $_eventObject = 'vendor_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Semeniuk\Vendor\Model\Vendor', 'Semeniuk\Vendor\Model\ResourceModel\Vendor');
    }
}
 