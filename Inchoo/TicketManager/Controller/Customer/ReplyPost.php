<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 3:18 PM
 */

namespace Inchoo\TicketManager\Controller\Customer;


use Inchoo\TicketManager\Api\ReplyRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\NoSuchEntityException;

class ReplyPost extends Customer
{
    /**
     * Customer session model
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * @var \Inchoo\TicketManager\Api\ReplyRepositoryInterface
     */
    protected $replyRepository;

    /**
     * @var \Inchoo\TicketManager\Model\ReplyFactory
     */
    protected $replyFactory;

    /**
     * ReplyPost constructor.
     * @param Context $context
     * @param ReplyRepositoryInterface $replyRepository
     * @param Session $customerSession
     * @param Validator $formKeyValidator
     * @param \Inchoo\TicketManager\Model\ReplyFactory $replyFactory
     */
    public function __construct(
        Context $context,
        ReplyRepositoryInterface $replyRepository,
        Session $customerSession,
        Validator $formKeyValidator,
        \Inchoo\TicketManager\Model\ReplyFactory $replyFactory,
        \Inchoo\TicketManager\Api\TicketRepositoryInterface $ticketRepository
    )
    {
        parent::__construct($context, $customerSession, $ticketRepository);
        $this->replyRepository = $replyRepository;
        $this->formKeyValidator = $formKeyValidator;
        $this->replyFactory = $replyFactory;
    }


    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $validFormKey = $this->formKeyValidator->validate($this->getRequest());

        if ($validFormKey && $this->getRequest()->isPost()) {
            try {
                $ticket = $this->loadAndValidateTicket();
                $inputData = $this->_request;
                $reply = $this->replyFactory->create();
                $reply->setMessage($inputData->getParam('reply'));
                $reply->setTicketId($ticket->getId());
                $this->replyRepository->save($reply);
                $this->messageManager->addSuccessMessage(__('You posted new reply.'));
            } catch (NoSuchEntityException $entityException) {
                return $this->redirectWithError();
            }
        }
        return $resultRedirect->setPath('*/*/');
    }

}