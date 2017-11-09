<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/9/17
 * Time: 1:36 PM
 */

namespace Inchoo\TicketEmail\Observer;


use Inchoo\TicketEmail\Model\ConfigInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface as PsrLogger;

class TicketEmailSender implements ObserverInterface
{

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var ConfigInterface
     */
    protected $ticketEmailConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var PsrLogger
     */
    protected $logger;

    public function __construct(
        TransportBuilder $transportBuilder,
        ConfigInterface $config,
        StoreManagerInterface $manager,
        PsrLogger $logger
    )
    {
        $this->transportBuilder = $transportBuilder;
        $this->ticketEmailConfig = $config;
        $this->storeManager = $manager;
        $this->logger = $logger;
    }


    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->ticketEmailConfig->isEnabled()) {
            $templateVars = array(
                'subject' => $observer->getEvent()->getSubject()
            );
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($this->ticketEmailConfig->emailTemplate())
                ->setTemplateOptions(
                    [
                        'area' => 'frontend',
                        'store' => $this->storeManager->getStore()->getId()
                    ]
                )
                ->setTemplateVars($templateVars)
                ->setFrom($this->ticketEmailConfig->emailSender())
                ->addTo($this->ticketEmailConfig->emailRecipient())
                ->getTransport();
            try {
                $transport->sendMessage();
            } catch (MailException $exception) {
                $this->logger->critical($exception);
            }

        }

    }
}