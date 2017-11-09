<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 11:53 AM
 */

namespace Inchoo\TicketManager\Model\ResourceModel\Ticket;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize ticket Collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Inchoo\TicketManager\Model\Ticket::class,
            \Inchoo\TicketManager\Model\ResourceModel\Ticket::class
        );
    }

}