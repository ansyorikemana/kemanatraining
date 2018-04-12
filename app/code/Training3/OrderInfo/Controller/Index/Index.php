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

namespace Training3\OrderInfo\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultFactory;
    

    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $orderRepositoryInterface;
   
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Training3\OrderInfo\Model\DataOrder $orderRepositoryInterface
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Training3\OrderInfo\Model\DataOrder $orderRepositoryInterface,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultFactory = $context->getResultFactory();
        $this->orderRepositoryInterface = $orderRepositoryInterface;
        $this->registry = $registry;
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
       
        /*var $result \Magento\Framework\Controller\ResultFactory */
        $result = $this->resultFactory->create($this->getFactoryType());
        
        try {
            $orderData =  $this->orderRepositoryInterface->getDataOrder($orderId);
    

            //registry here
            $this->registry->register('order_data', $orderData);
            
            
            if ($this->isJsonRequest() && !empty($dataOrder)) {
                $result->setData($orderData);
            } elseif ($this->isJsonRequest() && empty($orderData)) {
                $result->setData(
                    [
                        'error' => __('Order not found')
                    ]
                );
            }
        } catch (\Exception $e) {
            if ($this->isJsonRequest()) {
                $result->setData(
                    [
                        'error' => __('Order not found')
                    ]
                );
            }
        }
        
        return $result;
    }
    
    public function getFactoryType()
    {
        
        if ($this->isJsonRequest()) {
            return \Magento\Framework\Controller\ResultFactory::TYPE_JSON;
        }
        
        return \Magento\Framework\Controller\ResultFactory::TYPE_PAGE;
    }
    
    public function isJsonRequest()
    {
        return $this->getRequest()->getParam('json');
    }
}
