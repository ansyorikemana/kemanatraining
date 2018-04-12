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

namespace Training3\OrderInfo\Block\Index;

/*use Training3\OrderInfo\Model\DataOrder;*/

class Index extends \Magento\Framework\View\Element\Template
{
    
    /**
     * @var Training3\OrderInfo\Model\DataOrder
     */
    protected $orderInfo;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Training3\OrderInfo\Model\DataOrder $dataOrder
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }
    
    /**
     * Get Order Data
     *
     * @return array
     */
    public function getOrderData()
    {
        return $this->registry->registry('order_data');
    }
}
