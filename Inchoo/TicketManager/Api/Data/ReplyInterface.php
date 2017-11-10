<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/6/17
 * Time: 3:30 PM
 */

namespace Inchoo\TicketManager\Api\Data;


interface ReplyInterface
{

    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const REPLY_ID = 'ticket_reply_id';
    const MESSAGE = 'message';
    const ADMIN_ID = 'admin_id';
    const TICKET_ID = 'ticket_id';
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
     * @return ReplyInterface
     */
    public function setId($id);

    /**
     * get message
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * @param $message
     * @return ReplyInterface
     */
    public function setMessage($message);

    /**
     * get admin id
     *
     * @return int|null
     */
    public function getAdminId();

    /**
     * @param $adminId
     * @return ReplyInterface
     */
    public function setAdminId($adminId);

    /**
     * get ticket id
     *
     * @return int|null
     */
    public function getTicketId();

    /**
     * @param $ticketId
     * @return ReplyInterface
     */
    public function setTicketId($ticketId);

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * @param $createdAt
     * @return ReplyInterface
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
     * @return ReplyInterface
     */
    public function setUpdatedAt($updatedAt);
}