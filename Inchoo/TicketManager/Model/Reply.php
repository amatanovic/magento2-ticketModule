<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 3:24 PM
 */

namespace Inchoo\TicketManager\Model;


use Inchoo\TicketManager\Api\Data\ReplyInterface;
use Magento\Framework\Model\AbstractModel;

class Reply extends AbstractModel implements ReplyInterface
{

    /**
     * Initialize reply Model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Inchoo\TicketManager\Model\ResourceModel\Reply::class);
    }

    /**
     * Retrieve block id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::REPLY_ID);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return ReplyInterface
     */
    public function setId($id)
    {
        return $this->setData(self::REPLY_ID, $id);
    }

    /**
     * get message
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * @param $message
     * @return ReplyInterface
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * get admin id
     *
     * @return int|null
     */
    public function getAdminId()
    {
        return $this->getData(self::ADMIN_ID);
    }

    /**
     * @param $adminId
     * @return ReplyInterface
     */
    public function setAdminId($adminId)
    {
        return $this->setData(self::ADMIN_ID, $adminId);
    }

    /**
     * get ticket id
     *
     * @return int|null
     */
    public function getTicketId()
    {
        return $this->getData(self::TICKET_ID);
    }

    /**
     * @param $ticketId
     * @return ReplyInterface
     */
    public function setTicketId($ticketId)
    {
        return $this->setData(self::TICKET_ID, $ticketId);
    }

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @param $createdAt
     * @return ReplyInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param $updatedAt
     * @return ReplyInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

}