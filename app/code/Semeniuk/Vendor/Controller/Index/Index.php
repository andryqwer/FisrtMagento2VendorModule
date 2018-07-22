<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 13:04
 */

namespace Semeniuk\Vendor\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $_vendorFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Semeniuk\Vendor\Model\VendorFactory $vendorFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_vendorFactory = $vendorFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $vendor = $this->_vendorFactory->create();
        $collection = $vendor->getCollection();
        foreach($collection as $item){
            echo "<pre>";
            print_r($item->getData());
            echo "</pre>";
        }
        exit();
        return $this->_pageFactory->create();
    }
}