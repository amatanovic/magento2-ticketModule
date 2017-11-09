<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 9:07 AM
 */

namespace Inchoo\TicketManager\Controller\Customer;

use Magento\Backend\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Result\PageFactory;

class NewAction extends Customer
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context, $customerSession);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Customer order history
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('New ticket'));
        if ($navigationBlock = $resultPage->getLayout()->getBlock('customer_account_navigation')) {
            $navigationBlock->setActive('tickets/customer');
        }
        return $resultPage;
    }

}