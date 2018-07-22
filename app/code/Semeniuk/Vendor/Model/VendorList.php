<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 21:41
 */

namespace Semeniuk\Vendor\Model;

class VendorList extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    protected  $_vendor;

    /**
     *
     * @param \Semeniuk\Vendor\Model\Vendor $vendor
     */
    public function __construct(
        \Semeniuk\Vendor\Model\Vendor $vendor
    ) {
        $this->_vendor = $vendor;
    }

    /**
     * Get template
     *
     * @return array
     */
    public function getAvailableTemplate()
    {
        $vendors = $this->_vendor->getCollection();
        $listVendor = array();
        foreach ($vendors as $vendor) {
            $listVendor[] = array('label' => $vendor->getName(),
                'value' => $vendor->getId());
        }
        return $listVendor;
    }

    /**
     * Get model option as array
     *
     * @return array
     */
    public function getAllOptions($withEmpty = true)
    {
        $options = array();
        $options = $this->getAvailableTemplate();

        if ($withEmpty) {
            array_unshift($options, array(
                'value' => '',
                'label' => '-- Please Select --',
            ));
        }
        return $options;
    }
}