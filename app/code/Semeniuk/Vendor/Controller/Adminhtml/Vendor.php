<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 17:03
 */

namespace Semeniuk\Vendor\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Semeniuk\Vendor\Model\VendorFactory;

class Vendor extends Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Result page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * Vendor model factory
     *
     * @var \Semeniuk\Vendor\Model\VendorFactory
     */
    protected $_vendorFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param VendorFactory $vendorFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        VendorFactory $vendorFactory
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_vendorFactory = $vendorFactory;
    }

    /**
     * Vendor access rights checking
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Semeniuk_Vendor::semeniuk_vendor');
    }

    public function execute()
    {
    }
}
