<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 16:32
 */

namespace Semeniuk\Vendor\Controller\Adminhtml\Vendor;

use Semeniuk\Vendor\Controller\Adminhtml\Vendor;

class Save extends Vendor
{
    /**
     * @return void
     */
    public function execute()
    {
        $isPost = $this->getRequest()->getPost();

        if ($isPost) {
            $vendorModel = $this->_vendorFactory->create();
            $vendorId = $this->getRequest()->getParam('id');

            /*if (!$vendorId && isset($vendorId['vendor_id'])) {
                $vendorId = (int)$vendorId['vendor_id'] ?: 0;
            }*/ //need fix

            if ($vendorId) {
                $vendorModel->load($vendorId);
            }
            $formData = $this->getRequest()->getParam('vendor');

            $vendorModel->setData($formData);

            try {
                // Save vendor
                $vendorModel->save();

                // Display success message
                $this->messageManager->addSuccess(__('The vendor has been saved.'));

                // Check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $vendorModel->getId(), '_current' => true]);
                    return;
                }

                // Go to grid page
                $this->_redirect('*/*/');
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }

            $this->_getSession()->setFormData($formData);
            $this->_redirect('*/*/edit', ['id' => $vendorId]);
        }
    }
}