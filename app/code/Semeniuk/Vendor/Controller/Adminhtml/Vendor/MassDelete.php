<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 16:35
 */

namespace Semeniuk\Vendor\Controller\Adminhtml\Vendor;

use Semeniuk\Vendor\Controller\Adminhtml\Vendor;

class MassDelete extends Vendor
{
    /**
     * @return void
     */
    public function execute()
    {

        // Get IDs of the selected vendors
        $vendorsIds = $this->getRequest()->getParam('selected'); //need fix

        foreach ($vendorsIds as $vendorId) {
            try {
                /** @var $vendorModel \Semeniuk\Vendor\Model\Vendor */
                $vendorModel = $this->_vendorFactory->create();
                $vendorModel->load($vendorId)->delete();
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        if (count($vendorsIds)) {
            $this->messageManager->addSuccess(
                __('A total of %1 record(s) were deleted.', count($vendorsIds))
            );
        }

        $this->_redirect('*/*/index');
    }
}
