<?php

namespace Inchoo\TicketManager\Api\Data;

interface TicketInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const TICKET_ID = 'ticket_id';
    const SUBJECT = 'subject';
    const MESSAGE = 'message';
    const IS_CLOSED = 'is_closed';
    const CUSTOMER_ID = 'customer_id';
    const WEBSITE_ID = 'website_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     * @return TicketInterface
     */
    public function setId($id);

    /**
     * Get subject
     *
     * @return string|null
     */
    public function getSubject();

    /**
     * @param string $subject
     * @return TicketInterface
     */
    public function setSubject($subject);

    /**
     * Get message
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * @param string $message
     * @return TicketInterface
     */
    public function setMessage($message);

    /**
     * Get is closed
     *
     * @return bool|null
     */
    public function getIsClosed();

    /**
     * @param $isClosed
     * @return TicketInterface
     */
    public function setIsClosed($isClosed);

    /**
     * Get customer id
     *
     * @return int|null
     */
    public function getCustomerId();

    /**
     * @param int $customerId
     * @return TicketInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get website id
     *
     * @return int|null
     */
    public function getWebsiteId();

    /**
     * @param $websiteId
     * @return TicketInterface
     */
    public function setWebsiteId($websiteId);

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * @param $createdAt
     * @return TicketInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * @param $updatedAt
     * @return TicketInterface
     */
    public function setUpdatedAt($updatedAt);

}
