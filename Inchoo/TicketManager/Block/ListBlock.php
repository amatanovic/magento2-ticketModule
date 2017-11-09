<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/3/17
 * Time: 11:59 AM
 */

namespace Inchoo\TicketManager\Block;


use Inchoo\TicketManager\Api\Data\TicketInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Store\Model\StoreManagerInterface;

class ListBlock extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Inchoo\TicketManager\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var StoreManagerInterface $storeManager
     */
    protected $storeManager;

    /**
     * @var TicketInterface[]
     */
    protected $ticketCollection;


    /**
     * ListBlock constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Inchoo\TicketManager\Api\TicketRepositoryInterface $ticketRepository
     * @param \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Inchoo\TicketManager\Api\TicketRepositoryInterface $ticketRepository,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        \Magento\Customer\Model\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        parent::__construct($context);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->ticketRepository = $ticketRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->customerSession = $session;
        $this->storeManager = $storeManager;
    }

    /**
     * @return string
     */
    public function getNewUrl()
    {
        return $this->getUrl('tickets/customer/new', ['_secure' => true]);
    }

    /**
     * @return TicketInterface[]
     */
    public function getTickets()
    {
        if ($this->ticketCollection == null) {
            $this->sortOrderBuilder
                ->setField('created_at')
                ->setDescendingDirection();
            $orderByCreatedAt = $this->sortOrderBuilder->create();

            $this->searchCriteriaBuilder
                ->addFilter(TicketInterface::CUSTOMER_ID, $this->customerSession->getCustomerId(), 'eq')
                ->addFilter(TicketInterface::WEBSITE_ID, $this->storeManager->getStore()->getWebsiteId(), 'eq')
                ->addSortOrder($orderByCreatedAt);
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $this->ticketCollection = $this->ticketRepository->getList($searchCriteria)->getItems();
        }
        return $this->ticketCollection;
    }

    /**
     * @return string
     */
    public function getDetailUrl($id)
    {
        return $this->getUrl('tickets/customer/detail/id/', ['id' => $id, '_secure' => true]);
    }

    /**
     * @param string $date
     * @return string
     */
    public function dateFormat($date)
    {
        return $this->formatDate($date, \IntlDateFormatter::MEDIUM);
    }

}