<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 11:42 AM
 */

namespace Inchoo\TicketManager\Controller\Customer;


use Inchoo\TicketManager\Api\TicketRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Store\Model\StoreManagerInterface;

class Submit extends Customer
{
    /**
     * Customer session model
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var Validator
     */
    protected $formKeyValidator;

    /**
     * @var \Inchoo\TicketManager\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * @var \Inchoo\TicketManager\Model\TicketFactory
     */
    protected $ticketFactory;

    /**
     * @var StoreManagerInterface $storeManager
     */
    protected $storeManager;

    /**
     * @var ManagerInterface
     */
    private $eventManager;

    /**
     * Submit constructor.
     * @param Context $context
     * @param TicketRepositoryInterface $ticketRepository
     * @param Session $customerSession
     * @param Validator $formKeyValidator
     * @param \Inchoo\TicketManager\Model\TicketFactory $ticketFactory
     * @param StoreManagerInterface $storeManager
     * @param ManagerInterface $manager
     */
    public function __construct(
        Context $context,
        TicketRepositoryInterface $ticketRepository,
        Session $customerSession,
        Validator $formKeyValidator,
        \Inchoo\TicketManager\Model\TicketFactory $ticketFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        ManagerInterface $manager
    )
    {
        parent::__construct($context, $customerSession, $ticketRepository);
        $this->ticketRepository = $ticketRepository;
        $this->formKeyValidator = $formKeyValidator;
        $this->ticketFactory = $ticketFactory;
        $this->storeManager = $storeManager;
        $this->eventManager = $manager;
    }


    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $validFormKey = $this->formKeyValidator->validate($this->getRequest());

        if ($validFormKey && $this->getRequest()->isPost()) {
            $inputData = $this->_request;
            $ticket = $this->ticketFactory->create();
            $ticket->setSubject($inputData->getParam('subject'));
            $ticket->setMessage($inputData->getParam('message'));
            $ticket->setCustomerId($this->customerSession->getCustomerId());
            $ticket->setWebsiteId($this->storeManager->getStore()->getWebsiteId());
            try {
                $this->ticketRepository->save($ticket);
                $this->eventManager->dispatch(
                    'ticket_saved',
                    ['subject' => $inputData->getParam('subject')]
                );
                $this->messageManager->addSuccessMessage(__('You created new ticket.'));
            } catch (CouldNotSaveException $exception) {
                $this->messageManager->addErrorMessage(__('Ticket is not created.'));
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}