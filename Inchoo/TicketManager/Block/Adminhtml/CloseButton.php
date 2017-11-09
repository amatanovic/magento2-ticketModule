<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/8/17
 * Time: 12:56 PM
 */

namespace Inchoo\TicketManager\Block\Adminhtml;


use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class CloseButton extends AbstractBlock implements ButtonProviderInterface
{
    /**
     * Delete button
     *
     * @return array
     */
    public function getButtonData()
    {
            return [
                'id' => 'close',
                'label' => __('Close Ticket'),
                'on_click' => "location.href='" . $this->getCloseUrl() . "'",
                'class' => 'delete',
                'sort_order' => 10
            ];
    }

    /**
     * @param array $args
     * @return string
     */
    public function getCloseUrl(array $args = [])
    {
        $params = array_merge($this->getDefaultUrlParams(), $args);
        $url = $this->getUrl('tickets/customer/close', $params);
        return $url;
    }

    /**
     * @return array
     */
    protected function getDefaultUrlParams()
    {
        return ['_current' => true];
    }

}