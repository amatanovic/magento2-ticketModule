<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/8/17
 * Time: 2:55 PM
 */

namespace Inchoo\TicketManager\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class Close extends Customer
{
    /**
     * Customer session model
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Inchoo\TicketManager\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * Close constructor.
     * @param Context $context
     * @param \Inchoo\TicketManager\Api\TicketRepositoryInterface $ticketRepository
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        \Inchoo\TicketManager\Api\TicketRepositoryInterface $ticketRepository,
        Session $customerSession
    )
    {
        parent::__construct($context, $customerSession, $ticketRepository);
        $this->ticketRepository = $ticketRepository;
    }


    public function execute()
    {
        try {
            $ticket = $this->loadAndValidateTicket();
            $resultRedirect = $this->resultRedirectFactory->create();
            try {
                $this->ticketRepository->close($ticket);
                $this->messageManager->addSuccessMessage(__('Ticket is closed.'));
            } catch (CouldNotSaveException $entityException) {
                $this->messageManager->addErrorMessage(__('There was a problem closing this ticket.'));
            }
        } catch (NoSuchEntityException $exception) {
            return $this->redirectWithError();
        }
        return $resultRedirect->setPath('*/*/');
    }

}