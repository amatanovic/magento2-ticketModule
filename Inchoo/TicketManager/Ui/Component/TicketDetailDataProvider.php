<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/10/17
 * Time: 11:41 AM
 */

namespace Inchoo\TicketManager\Ui\Component;


class TicketDetailDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param \Inchoo\TicketManager\Model\ResourceModel\Ticket\CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\TicketManager\Model\ResourceModel\Ticket\CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $dataObject = $this->getCollection()->getFirstItem();
        $data = [
            $dataObject->getId() => $dataObject->toArray()
        ];

        return $data;
    }
}