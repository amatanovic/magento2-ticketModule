<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/3/17
 * Time: 11:59 AM
 */

namespace Inchoo\TicketManager\Block;


use Inchoo\TicketManager\Api\Data\TicketInterface;
use Inchoo\TicketManager\Model\ResourceModel\Ticket\Collection;
use Magento\Store\Model\StoreManagerInterface;

class ListBlock extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var StoreManagerInterface $storeManager
     */
    protected $storeManager;

    /**
     * @var Collection
     */
    protected $ticketCollection;

    /**
     * @var CollectionFactory
     */
    protected $ticketCollectionFactory;


    /**
     * ListBlock constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $session
     * @param StoreManagerInterface $storeManager
     * @param \Inchoo\TicketManager\Model\ResourceModel\Ticket\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Inchoo\TicketManager\Model\ResourceModel\Ticket\CollectionFactory $collectionFactory
    )
    {
        parent::__construct($context);
        $this->customerSession = $session;
        $this->storeManager = $storeManager;
        $this->ticketCollectionFactory = $collectionFactory;
    }

    /**
     * @return string
     */
    public function getNewUrl()
    {
        return $this->getUrl('tickets/customer/new', ['_secure' => true]);
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
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

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getTickets()) {
            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'tickets.pager'
            )->setCollection(
                $this->getTickets()
            );
            $this->setChild('pager', $pager);
            $this->getTickets()->load();
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getTickets()
    {
        if ($this->ticketCollection == null) {

            $this->ticketCollection = $this->ticketCollectionFactory->create()
                ->addFieldToFilter(
                    TicketInterface::WEBSITE_ID,
                    ['eq' => $this->storeManager->getStore()->getWebsiteId()]
                )->addFieldToFilter(
                    TicketInterface::CUSTOMER_ID,
                    ['eq' => $this->customerSession->getCustomerId()]
                )->setOrder(
                    'created_at',
                    'desc'
                );

            /*
             * Pagination is added so I can't use repository any more
             *
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
            */
        }
        return $this->ticketCollection;
    }

}