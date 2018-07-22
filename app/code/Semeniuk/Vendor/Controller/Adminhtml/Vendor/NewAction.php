<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 16:18
 */

namespace Semeniuk\Vendor\Controller\Adminhtml\Vendor;

use Semeniuk\Vendor\Controller\Adminhtml\Vendor;

class NewAction extends Vendor
{
    /**
     * Create new vendor action
     *
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}