<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/8/17
 * Time: 1:09 PM
 */

namespace Inchoo\TicketManager\Controller\Adminhtml\Customer;

use Inchoo\TicketManager\Api\TicketRepositoryInterface;
use Magento\Backend\App\Action\Context;

class Close extends AbstractAction
{
    /**
     * @var \Inchoo\TicketManager\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $session;

    /**
     * @param Context $context
     * @param TicketRepositoryInterface $ticketRepository
     */
    public function __construct(
        Context $context,
        TicketRepositoryInterface $ticketRepository,
        \Magento\Backend\Model\Auth\Session $authSession
    )
    {
        $this->ticketRepository = $ticketRepository;
        $this->session = $authSession;
        parent::__construct($context);
    }


    public function execute()
    {
        $ticketId = (int)$this->getRequest()->getParam('id', false);
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $ticket = $this->ticketRepository->getById($ticketId);
            $this->ticketRepository->close($ticket);
            $this->messageManager->addSuccessMessage(__('Ticket is closed.'));

        } catch (\Exception $entityException) {
            $this->messageManager->addErrorMessage(__('There was a problem closing this ticket.'));
        }
        return $resultRedirect->setPath('*/*/');
    }

}