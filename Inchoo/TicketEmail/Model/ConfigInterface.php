<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/9/17
 * Time: 2:10 PM
 */

namespace Inchoo\TicketEmail\Model;


interface ConfigInterface
{

    const XML_PATH_ENABLED = 'ticketManager/email/send';

    const XML_PATH_EMAIL_SENDER = 'ticketManager/email/sender';

    const XML_PATH_EMAIL_RECIPIENT = 'ticketManager/email/recipient_email';

    const XML_PATH_EMAIL_TEMPLATE = 'ticketManager/email/email_template';

    public function isEnabled();


    public function emailTemplate();


    public function emailSender();


    public function emailRecipient();

}