<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 3:18 PM
 */

namespace Inchoo\TicketManager\Controller\Adminhtml\Customer;


use Inchoo\TicketManager\Api\ReplyRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\CouldNotSaveException;

class Save extends AbstractAction
{
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
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $session;

    /**
     * @param Context $context
     * @param ReplyRepositoryInterface $replyRepository
     * @param Validator $formKeyValidator
     * @param \Inchoo\TicketManager\Model\ReplyFactory $replyFactory
     */
    public function __construct(
        Context $context,
        ReplyRepositoryInterface $replyRepository,
        Validator $formKeyValidator,
        \Inchoo\TicketManager\Model\ReplyFactory $replyFactory,
        \Magento\Backend\Model\Auth\Session $authSession
    )
    {
        $this->replyRepository = $replyRepository;
        $this->formKeyValidator = $formKeyValidator;
        $this->replyFactory = $replyFactory;
        $this->session = $authSession;
        parent::__construct($context);
    }


    /**
     * @return $this
     * @todo surround with try catch
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $validFormKey = $this->formKeyValidator->validate($this->getRequest());

        if ($validFormKey && $this->getRequest()->isPost()) {
            $inputData = $this->_request;
            $reply = $this->replyFactory->create();
            $reply->setMessage($inputData->getParam('reply'));
            $reply->setTicketId($inputData->getParam('ticket_id'));
            $reply->setAdminId($this->session->getUser()->getId());
            try {
                $this->replyRepository->save($reply);
                $this->messageManager->addSuccessMessage(__('You posted new reply.'));
            } catch (CouldNotSaveException $exception) {
                $this->messageManager->addErrorMessage(__('There was an error saving reply.'));
            }
        }

        return $resultRedirect->setPath('*/*/');
    }

}