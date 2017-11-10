<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 3:25 PM
 */

namespace Inchoo\TicketManager\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Reply extends AbstractDb
{
    /**
     * Initialize Reply Resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('inchoo_ticket_reply', 'ticket_reply_id');
    }

}