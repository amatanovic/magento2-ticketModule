<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 3:31 PM
 */

namespace Inchoo\TicketManager\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ReplySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get replies list.
     *
     * @return \Inchoo\TicketManager\Api\Data\ReplyInterface[]
     */
    public function getItems();

    /**
     * Set reply list.
     *
     * @param \Inchoo\TicketManager\Api\Data\ReplyInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
