<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 3:25 PM
 */

namespace Inchoo\TicketManager\Model;


use Inchoo\TicketManager\Api\Data\ReplyInterface;
use Inchoo\TicketManager\Api\Data\ReplySearchResultsInterface;
use Inchoo\TicketManager\Api\ReplyRepositoryInterface;
use Inchoo\TicketManager\Api\SearchCriteriaInterface;
use Inchoo\TicketManager\Api\TicketInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ReplyRepository implements ReplyRepositoryInterface
{

    /**
     * @var \Inchoo\TicketManager\Api\Data\ReplyInterfaceFactory
     */
    protected $replyModelFactory;

    /**
     * @var \Inchoo\TicketManager\Model\ResourceModel\Reply\
     */
    protected $replyResource;

    /**
     * @var \Inchoo\TicketManager\Model\ResourceModel\Reply\CollectionFactory
     */
    protected $replyCollectionFactory;

    /**
     * @var \Inchoo\TicketManager\Api\Data\ReplySearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;


    public function __construct(
        \Inchoo\TicketManager\Api\Data\ReplyInterfaceFactory $replyInterfaceFactory,
        \Inchoo\TicketManager\Model\ResourceModel\Reply $reply,
        \Inchoo\TicketManager\Model\ResourceModel\Reply\CollectionFactory $collectionFactory,
        \Inchoo\TicketManager\Api\Data\ReplySearchResultsInterfaceFactory $searchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->replyModelFactory = $replyInterfaceFactory;
        $this->replyResource = $reply;
        $this->replyCollectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Retrieve reply.
     *
     * @param int $replyId
     * @return \Inchoo\TicketManager\Api\Data\ReplyInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($replyId)
    {
        $reply = $this->replyModelFactory->create();
        $this->replyResource->load($reply, $replyId);
        if (!$reply->getId()) {
            throw new NoSuchEntityException(__('Reply with id "%1" does not exist.', $replyId));
        }
        return $reply;
    }

    /**
     * @param ReplyInterface $reply
     * @return ReplyInterface
     * @throws CouldNotSaveException
     */
    public function save(ReplyInterface $reply)
    {
        try {
            $this->replyResource->save($reply);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $reply;
    }

    /**
     * @param ReplyInterface $reply
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ReplyInterface $reply)
    {
        try {
            $this->replyResource->delete($reply);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Retrieve replies matching the specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\TicketManager\Api\Data\ReplySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Inchoo\TicketManager\Model\ResourceModel\Reply\Collection $collection */
        $collection = $this->replyCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var ReplySearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}