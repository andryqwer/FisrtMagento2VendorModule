<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 16:23
 */

namespace Semeniuk\Vendor\Controller\Adminhtml\Vendor;

use Semeniuk\Vendor\Controller\Adminhtml\Vendor;

class Edit extends Vendor
{

    /**
     * @return void
     */
    public function execute()
    {
        $vendorId = $this->getRequest()->getParam('id');
        /** @var \Semeniuk\Vendor\Model\Vendor $model */
        $model = $this->_vendorFactory->create();

        if ($vendorId) {
            $model->load($vendorId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This vendor no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }


        // Restore previously entered form data from session
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true); //need fix
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('semeniuk_vendor_vendor', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Semeniuk_Vendor::main_menu'); //need fix remove
        $resultPage->getConfig()->getTitle()->prepend(__('Entity Vendor'));

        return $resultPage;
    }
}
