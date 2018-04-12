<?php

/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training2
 * @package  Training2_OrderController
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */

namespace Training2\OrderController\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;
    
    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $orderRepository;


    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->orderRepository = $orderRepository;

        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $orderId = $this->getRequest()->getParam('orderID');
        $resultJson = $this->resultJsonFactory->create();
        try {
            $order =  $this->orderRepository->get($orderId);
    
            $items = array();
            foreach ($order->getItems() as $item) {
                $items[] = [
                    'sku'     => $item->getSku(),
                    'item_id' => $item->getId(),
                    'price'   => $item->getPriceInclTax(),
                ];
            }
    
            $json = [
                'status'         => $order->getStatus(),
                'total'          => $order->getGrandTotal(),
                'total_invoiced' => $order->getTotalInvoiced(),
                'items'          => $items,
            ];
            
            $resultJson->setData($json);
        } catch (\Exception $e) {
            $resultJson->setData(
                [
                    'error' => __('Order not found')
                ]
            );
        }
        
        return $resultJson;
    }
}
