<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/8/17
 * Time: 1:31 PM
 */

namespace Inchoo\TicketManager\Controller\Adminhtml\Customer;


abstract class AbstractAction extends \Magento\Backend\App\Action
{
    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Inchoo_TicketManager::tickets');
    }

}