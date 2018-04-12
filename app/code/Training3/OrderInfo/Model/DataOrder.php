<?php

/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training3
 * @package  Training3_OrderInfo
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */

namespace Training3\OrderInfo\Model;

use Magento\Sales\Api\OrderRepositoryInterface;

class DataOrder
{
    
    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $order;

    /**
     * Constructor.
     *
     * @param OrderRepositoryInterface $orderRepositoryInterface
     */
    public function __construct(OrderRepositoryInterface $orderRepositoryInterface)
    {
        $this->order = $orderRepositoryInterface;
    }
    
    /**
     * Get Order Data
     *
     * @param integer $orderId
     *
     * @return array
     */
    public function getDataOrder($orderId = 0)
    {
        $orderData = [];
        $items = [];

        if ($orderId && (int) $orderId) {
            $order = $this->order->get($orderId);
            foreach ($order->getItems() as $item) {
                $items[] = array(
                    'sku'     => $item->getSku(),
                    'item_id' => $item->getId(),
                    'price'   => $item->getPriceInclTax(),
                );
            }

            $orderData['status'] = $order->getStatus();
            $orderData['total'] = $order->getGrandTotal();
            $orderData['total_invoiced'] = $order->getTotalInvoiced();
            $orderData['items'] = $items;
            return $orderData;
        }
        
        return false;
    }
}
