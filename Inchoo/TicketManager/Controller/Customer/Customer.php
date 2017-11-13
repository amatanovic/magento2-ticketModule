<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/3/17
 * Time: 2:37 PM
 */

namespace Inchoo\TicketManager\Controller\Customer;

use Inchoo\TicketManager\Api\Data\TicketInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;

abstract class Customer extends Action
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
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        \Inchoo\TicketManager\Api\TicketRepositoryInterface $ticketRepository
    )
    {
        $this->customerSession = $customerSession;
        $this->ticketRepository = $ticketRepository;
        parent::__construct($context);
    }

    /**
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->customerSession->authenticate()) {
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
        }
        return parent::dispatch($request);
    }


    /**
     * @return TicketInterface
     * @throws NoSuchEntityException
     */
    protected function loadAndValidateTicket()
    {
        $ticketId = (int)$this->getRequest()->getParam('id', false);
        if ($ticketId) {
            $ticket = $this->ticketRepository->getById($ticketId);
            if ($ticket->getCustomerId() !== $this->customerSession->getCustomerId()) {
                throw new NoSuchEntityException();
            }
            return $ticket;
        }
        throw new NoSuchEntityException();
    }


    protected function redirectWithError()
    {
        $this->messageManager->addErrorMessage(__('Requested ticket was not found.'));
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('tickets/customer');
        return $resultRedirect;
    }

}