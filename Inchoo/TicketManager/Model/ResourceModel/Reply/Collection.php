<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 3:26 PM
 */

namespace Inchoo\TicketManager\Model\ResourceModel\Reply;


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
            \Inchoo\TicketManager\Model\Reply::class,
            \Inchoo\TicketManager\Model\ResourceModel\Reply::class
        );
    }

}