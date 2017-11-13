<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 2:26 PM
 */

namespace Inchoo\TicketManager\Controller\Customer;


use Inchoo\TicketManager\Api\TicketRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Detail extends Customer
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
     * View constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param TicketRepositoryInterface $ticketRepository
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Inchoo\TicketManager\Api\TicketRepositoryInterface $ticketRepository,
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\Session $customerSession
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->registry = $registry;
        $this->ticketRepository = $ticketRepository;
        parent::__construct($context, $customerSession, $ticketRepository);
    }


    public function execute()
    {
        try {
            $ticket = $this->loadAndValidateTicket();
            $this->registry->register('current_ticket', $ticket);
            $this->registry->register('customer_template_view', true);
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->set($ticket->getSubject());
            if ($navigationBlock = $resultPage->getLayout()->getBlock('customer_account_navigation')) {
                $navigationBlock->setActive('tickets/customer');
            }
            return $resultPage;
        } catch (NoSuchEntityException $entityException) {
            return $this->redirectWithError();
        }
    }
}