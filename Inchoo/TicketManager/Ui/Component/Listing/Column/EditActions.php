<?php

namespace Inchoo\TicketManager\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class EditActions
 */
class EditActions extends Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as & $item) {
            if (isset($item['ticket_id'])) {
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->context->getUrl(
                            'tickets/customer/edit',
                            ['id' => $item['ticket_id']]
                        ),
                        'label' => __('Edit')
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
