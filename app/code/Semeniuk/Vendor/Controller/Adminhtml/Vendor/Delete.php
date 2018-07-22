<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 16:33
 */

namespace Semeniuk\Vendor\Controller\Adminhtml\Vendor;

use Semeniuk\Vendor\Controller\Adminhtml\Vendor;

class Delete extends Vendor
{
    /**
     * @return void
     */
    public function execute()
    {
        $vendorId = (int) $this->getRequest()->getParam('id');

        if ($vendorId) {
            /** @var $vendorModel \Semeniuk\Vendor\Model\Vendor */
            $vendorModel = $this->_vendorFactory->create();
            $vendorModel->load($vendorId);

            // Check this vendor exists or not
            if (!$vendorModel->getId()) {
                $this->messageManager->addError(__('This vendor no longer exists.'));
            } else {
                try {
                    // Delete vendor
                    $vendorModel->delete();
                    $this->messageManager->addSuccess(__('The vendor has been deleted.'));

                    // Redirect to grid page
                    $this->_redirect('*/*/');
                    return;
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                    $this->_redirect('*/*/edit', ['id' => $vendorModel->getId()]);
                }
            }
        }
    }
}

