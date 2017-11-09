<?php

namespace Inchoo\TicketManager\Ui\Component;

class TicketsDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
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
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        /**
         * This is just a hack-around to use one DataProvider for both grid and form,
         * it's probably really bad idea
         */
        if($this->getName() == 'ticket_form_data_source') {

            $dataObject = $this->getCollection()->getFirstItem();

            $data = [
                $dataObject->getId() => $dataObject->toArray()
            ];


        } else {
            $data = $this->getCollection()->toArray();
        }

        return $data;
    }
}