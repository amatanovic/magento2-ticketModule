<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/7/17
 * Time: 12:55 PM
 */

namespace Inchoo\TicketManager\Controller\Adminhtml\Customer;


use Inchoo\TicketManager\Api\TicketRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends AbstractAction
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Inchoo\TicketManager\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * Edit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param TicketRepositoryInterface $ticketRepository
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Inchoo\TicketManager\Api\TicketRepositoryInterface $ticketRepository,
        \Magento\Framework\Registry $registry
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->registry = $registry;
        $this->ticketRepository = $ticketRepository;
        parent::__construct($context);
    }


    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $ticketId = (int)$this->getRequest()->getParam('id', false);
        try {
            $ticket = $this->ticketRepository->getById($ticketId);
            $this->registry->register('current_ticket', $ticket);
            $this->registry->register('customer_template_view', false);
            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $resultPage->setActiveMenu('Inchoo_TicketManager::tickets');
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Ticket'));
            return $resultPage;
        } catch (NoSuchEntityException $entityException) {
            $this->messageManager->addErrorMessage(__('Requested ticket was not found.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('tickets/customer/index');
            return $resultRedirect;
        }
    }
}