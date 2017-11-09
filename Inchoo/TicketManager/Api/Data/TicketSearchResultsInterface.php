<?php

namespace Inchoo\TicketManager\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TicketSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get tickets list.
     *
     * @return \Inchoo\TicketManager\Api\Data\TicketInterface[]
     */
    public function getItems();

    /**
     * Set ticket list.
     *
     * @param \Inchoo\TicketManager\Api\Data\TicketInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
