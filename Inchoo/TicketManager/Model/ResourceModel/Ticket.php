<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 11:51 AM
 */

namespace Inchoo\TicketManager\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Ticket extends AbstractDb
{
    /**
     * Initialize ticket Resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('inchoo_ticket', 'ticket_id');
    }

}