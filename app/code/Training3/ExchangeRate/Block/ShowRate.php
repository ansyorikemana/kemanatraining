<?php

/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training3
 * @package  Training3_ExchangeRate
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */
 
namespace Training3\ExchangeRate\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Training3\ExchangeRate\Model\ExchangeRates;

class ShowRate extends Template
{
    /**
     * @var Training3\ExchangeRate\Model\ExchangeRates
     */
    protected $exchangeRates;

    /**
     * @param \Magento\Framework\View\Element\Template\Context    $context
     * @param \Training3\ExchangeRate\Model\ExchangeRates         $getRates
     * @param array                                               $data
     */
    public function __construct(
        Context $context,
        ExchangeRates $exchangeRates,
        array $data = []
    ) {
        $this->exchangeRates = $exchangeRates;
        parent::__construct($context, $data);
    }
    
    /**
     * Show Rates
     *
     * @return string
     */
    
    public function showRates()
    {
        return $this->exchangeRates->showRates();
    }
}
