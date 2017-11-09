<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 11:55 AM
 */

namespace Inchoo\TicketManager\Api;


use Inchoo\TicketManager\Api\Data\TicketInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface TicketRepositoryInterface
{
    /**
     * Retrieve ticket.
     *
     * @param int $ticketId
     * @return \Inchoo\TicketManager\Api\Data\TicketInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($ticketId);

    /**
     * Save ticket.
     *
     * @param TicketInterface $ticket
     * @return TicketInterface
     * @internal param TicketInterface $ticket
     */
    public function save(TicketInterface $ticket);

    /**
     * Delete ticket.
     *
     * @param TicketInterface $ticket
     * @return bool true on success
     * @internal param TicketInterface $ticket
     */
    public function delete(TicketInterface $ticket);

    /**
     * Retrieve tickets matching the specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\TicketManager\Api\Data\TicketSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Close ticket.
     *
     * @param int $ticketId
     * @return \Inchoo\TicketManager\Api\Data\TicketInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function closeById($ticketId);

}