<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 11:50 AM
 */

namespace Inchoo\TicketManager\Model;


use Inchoo\TicketManager\Api\Data\TicketInterface;
use Magento\Framework\Model\AbstractModel;

class Ticket extends AbstractModel implements TicketInterface
{
    /**
     * Initialize ticket Model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Inchoo\TicketManager\Model\ResourceModel\Ticket::class);
    }

    /**
     * Retrieve block id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::TICKET_ID);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return TicketInterface
     */
    public function setId($id)
    {
        return $this->setData(self::TICKET_ID, $id);
    }

    /**
     * Get subject
     *
     * @return string|null
     */
    public function getSubject()
    {
        return $this->getData(self::SUBJECT);
    }

    /**
     * @param string $subject
     * @return TicketInterface
     */
    public function setSubject($subject)
    {
        return $this->setData(self::SUBJECT, $subject);
    }

    /**
     * Get message
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * @param string $message
     * @return TicketInterface
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * Get is closed
     *
     * @return bool|null
     */
    public function getIsClosed()
    {
        return $this->getData(self::IS_CLOSED);
    }

    /**
     * @param $isClosed
     * @return TicketInterface
     */
    public function setIsClosed($isClosed)
    {
        return $this->setData(self::IS_CLOSED, $isClosed);
    }

    /**
     * Get customer id
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @param int $customerId
     * @return TicketInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get website id
     *
     * @return int|null
     */
    public function getWebsiteId()
    {
        return $this->getData(self::WEBSITE_ID);
    }

    /**
     * @param $websiteId
     * @return TicketInterface
     */
    public function setWebsiteId($websiteId)
    {
        return $this->setData(self::WEBSITE_ID, $websiteId);
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
     * @return TicketInterface
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
     * @return TicketInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}