<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 9:17 AM
 */

namespace Inchoo\TicketManager\Block;


class NewBlock extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function getPostUrl()
    {
        return $this->getUrl('tickets/customer/submit', ['_secure' => true]);
    }

}