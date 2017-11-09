<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 2:25 PM
 */

namespace Inchoo\TicketManager\Block;


use Inchoo\TicketManager\Api\Data\ReplyInterface;
use Inchoo\TicketManager\Api\Data\TicketInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Registry;

class DetailBlock extends \Magento\Framework\View\Element\Template
{
    /**
     * @var TicketInterface
     */
    protected $ticket;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Inchoo\TicketManager\Api\ReplyRepositoryInterface
     */
    protected $replyRepository;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $session;

    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $userFactory;

    /**
     * @var \Magento\User\Model\ResourceModel\User
     */
    protected $userResource;

    protected $customerTemplate;

    /**
     * DetailBlock constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param Registry $registry
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Inchoo\TicketManager\Api\ReplyRepositoryInterface $replyRepository
     * @param \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param \Magento\User\Model\ResourceModel\User $userResource
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Inchoo\TicketManager\Api\ReplyRepositoryInterface $replyRepository,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\User\Model\ResourceModel\User $userResource
    )
    {
        parent::__construct($context);
        $this->registry = $registry;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->replyRepository = $replyRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->customerRepository = $customerRepository;
        $this->session = $authSession;
        $this->userFactory = $userFactory;
        $this->userResource = $userResource;
    }

    /**
     * @return ReplyInterface[]
     */
    public function getReplies()
    {
        $this->sortOrderBuilder
            ->setField('created_at')
            ->setDescendingDirection();
        $orderByCreatedAt = $this->sortOrderBuilder->create();

        $this->searchCriteriaBuilder
            ->addFilter(ReplyInterface::TICKET_ID, $this->getCurrentTicket()->getId(), 'eq')
            ->addSortOrder($orderByCreatedAt);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $result = $this->replyRepository->getList($searchCriteria)->getItems();
        return $result;
    }

    public function getCurrentTicket()
    {
        if ($this->ticket == null) {
            $this->ticket = $this->registry->registry('current_ticket');
        }
        return $this->ticket;
    }

    /**
     * @return string
     */
    public function getCustomerName()
    {
        if ($this->getCustomerTemplate()) {
            return 'Me';
        }
        $customer = $this->customerRepository->getById($this->getCurrentTicket()->getCustomerId());
        return $customer->getFirstname() . ' ' . $customer->getLastname();

    }

    /**
     * From controller is registered customer_template_view to distinct which name to display for reply in
     * admin and fronted side because I can't rely on session is some edge cases
     * @return bool
     */
    private function getCustomerTemplate()
    {
        if ($this->customerTemplate == null) {
            $this->customerTemplate = $this->registry->registry('customer_template_view');
        }
        return $this->customerTemplate;
    }

    /**
     * @param int $adminId
     * @return string
     */
    public function getUserName($adminId)
    {
        if ($this->getCustomerTemplate()) {
            $user = $this->userFactory->create();
            $this->userResource->load($user, $adminId);
            return $user->getName();
        }
        if ($adminId === $this->session->getUser()->getId()) {
            return 'Me';
        }
        return $this->session->getUser()->getName();
    }

    /**
     * @return string
     */
    public function getReplyPostUrl()
    {
        return $this->getUrl('tickets/customer/replypost', ['_secure' => true]);
    }

    /**
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('tickets/customer', ['_secure' => true]);
    }

    /**
     * @return string
     */
    public function getCloseUrl()
    {
        return $this->getUrl('tickets/customer/close', ['_secure' => true, 'id' => $this->getCurrentTicket()->getId()]);
    }

    /**
     * @param string $date
     * @return string
     */
    public function dateTimeFormat($date)
    {
        return $this->formatDate($date, \IntlDateFormatter::MEDIUM) .
            ' ' . $this->formatTime($date, \IntlDateFormatter::MEDIUM);
    }

}