<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 12:26 PM
 */

namespace Inchoo\TicketManager\Model;


use Inchoo\TicketManager\Api\Data\TicketInterface;
use Inchoo\TicketManager\Api\Data\TicketSearchResultsInterface;
use Inchoo\TicketManager\Api\TicketRepositoryInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class TicketRepository implements TicketRepositoryInterface
{
    /**
     * @var \Inchoo\TicketManager\Api\Data\TicketInterfaceFactory
     */
    protected $ticketModelFactory;

    /**
     * @var \Inchoo\TicketManager\Model\ResourceModel\Ticket
     */
    protected $ticketResource;

    /**
     * @var \Inchoo\TicketManager\Model\ResourceModel\Ticket\CollectionFactory
     */
    protected $ticketCollectionFactory;

    /**
     * @var \Inchoo\TicketManager\Api\Data\TicketSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;


    public function __construct(
        \Inchoo\TicketManager\Api\Data\TicketInterfaceFactory $ticketInterfaceFactory,
        \Inchoo\TicketManager\Model\ResourceModel\Ticket $ticket,
        \Inchoo\TicketManager\Model\ResourceModel\Ticket\CollectionFactory $collectionFactory,
        \Inchoo\TicketManager\Api\Data\TicketSearchResultsInterfaceFactory $searchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->ticketModelFactory = $ticketInterfaceFactory;
        $this->ticketResource = $ticket;
        $this->ticketCollectionFactory = $collectionFactory;

        $this->searchResultsFactory = $searchResultsInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Retrieve ticket.
     *
     * @param int $ticketId
     * @return \Inchoo\TicketManager\Api\Data\TicketInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($ticketId)
    {
        $ticket = $this->ticketModelFactory->create();
        $this->ticketResource->load($ticket, $ticketId);
        if (!$ticket->getId()) {
            throw new NoSuchEntityException(__('Ticket with id "%1" does not exist.', $ticketId));
        }
        return $ticket;
    }

    /**
     * Save ticket
     *
     * @param TicketInterface $ticket
     * @return TicketInterface
     * @throws CouldNotSaveException
     */
    public function save(TicketInterface $ticket)
    {
        try {
            $this->ticketResource->save($ticket);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $ticket;
    }

    /**
     * @param TicketInterface $ticket
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(TicketInterface $ticket)
    {
        try {
            $this->ticketResource->delete($ticket);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Retrieve tickets matching the specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\TicketManager\Api\Data\TicketSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Inchoo\TicketManager\Model\ResourceModel\Ticket\Collection $collection */
        $collection = $this->ticketCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var TicketSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Close ticket.
     *
     * @param int $ticketId
     * @return \Inchoo\TicketManager\Api\Data\TicketInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function closeById($ticketId)
    {
        $ticket = $this->getById($ticketId);
        $ticket->setIsClosed(true);
        try {
            $this->ticketResource->save($ticket);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $ticket;
    }
}