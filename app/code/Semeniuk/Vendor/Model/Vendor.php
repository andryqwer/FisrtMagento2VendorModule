<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 12:35
 */

namespace Semeniuk\Vendor\Model;

/**
 * Vendor Model
 */

class Vendor extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'semeniuk_vendor';

    protected $_cacheTag = 'semeniuk_vendor';

    protected $_eventPrefix = 'semeniuk_vendor';

    protected function _construct()
    {
        $this->_init('Semeniuk\Vendor\Model\ResourceModel\Vendor');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

}