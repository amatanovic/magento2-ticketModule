<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 3:29 PM
 */

namespace Inchoo\TicketManager\Api;


use Inchoo\TicketManager\Api\Data\ReplyInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;

interface ReplyRepositoryInterface
{
    /**
     * Retrieve reply.
     *
     * @param int $replyId
     * @return \Inchoo\TicketManager\Api\Data\TicketInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($replyId);

    /**
     * Save reply.
     *
     * @param ReplyInterface $reply
     * @return ReplyInterface
     * @throws CouldNotSaveException
     */
    public function save(ReplyInterface $reply);

    /**
     * Delete reply.
     *
     * @param ReplyInterface $reply
     * @return bool true on success
     * @throws CouldNotDeleteException
     */
    public function delete(ReplyInterface $reply);

    /**
     * Retrieve replies matching the specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\TicketManager\Api\Data\ReplySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

}