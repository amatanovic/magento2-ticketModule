<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/7/17
 * Time: 11:40 AM
 */

namespace Inchoo\TicketManager\Controller\Adminhtml\Customer;


use Magento\Framework\Controller\ResultFactory;

class Index extends AbstractAction
{

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Inchoo_TicketManager::tickets');
        $resultPage->getConfig()->getTitle()->prepend(__('Tickets'));

        return $resultPage;
    }

}
