<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/8/17
 * Time: 1:56 PM
 */

namespace Inchoo\TicketManager\Model\Ticket\Source;


use Magento\Framework\Data\OptionSourceInterface;

class IsOpened implements OptionSourceInterface
{
    const STATUS_OPENED = 0;
    const STATUS_CLOSED = 1;

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->getAvailableStatuses() as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }

    private function getAvailableStatuses()
    {
        return [self::STATUS_OPENED => __('Opened'), self::STATUS_CLOSED => __('Closed')];
    }
}
