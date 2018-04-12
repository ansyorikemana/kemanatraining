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
 
namespace Training3\ExchangeRate\Model;

use Magento\Framework\HTTP\ClientInterface;
use Magento\Framework\Json\DecoderInterface;
use Training3\ExchangeRate\Api\ExchangeRateInterface;

class ExchangeRates implements ExchangeRateInterface
{
    const RATES_URL = 'http://api.fixer.io/latest?base=';
    
    /**
     * @var \Training3\ExchangeRate\Model\ExchangeRates
     */
    protected $base = '';

    /**
     * @var Magento\Framework\HTTP\ClientInterface
     */
    protected $client = null;

    /**
     * @var \Magento\Framework\Json\DecoderInterface
     */
    protected $jsonDecoder;

    /**
     * Constructor.
     *
     * @param string          $baseName
     * @param ClientInterface $_client
     */
    public function __construct($baseCurrency, ClientInterface $_client, DecoderInterface $decoder)
    {
        $this->base = $baseCurrency;
        $this->client = $_client;
        $this->jsonDecoder = $decoder;
    }
    
    
    /**
     * @return float
     */
    
    public function showRates()
    {
        $this->client->get($this->getURL());
        if ($this->client->getStatus() !== 200) {
            return null;
        }
        $json = $this->client->getBody();
        $rates = (array)$this->jsonDecoder->decode($json);

        if ($rates['base'] === $this->base && isset($rates['rates']['EUR'])) {
            return (float)$rates['rates']['EUR'];
        }

        return null;
    }

    /**
     * @return string
     */
    protected function getURL()
    {
        return self::RATES_URL . $this->base;
    }
}
