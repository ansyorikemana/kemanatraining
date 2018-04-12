<?php

/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training1
 * @package  Training1_FreeGeoIp
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */

namespace Training1\FreeGeoIp\Observer\Visitor;

use Magento\Customer\Model\Visitor;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use \Magento\Framework\HTTP\ZendClient;

/**
 * Visitor Observer
 */
class InitByRequestObserver implements ObserverInterface
{
    /**
     * External URL to get visitor information by IP Address
     */
    const URL_DATA = 'http://freegeoip.net/json/';

    /**
     * Timeout variable used by http client call to external URL
     */
    const REQUEST_TIMEOUT = 10;
    
    /*
    * @var \Magento\Framework\Logger\Monolog
    */
    protected $logger;
    
    /*
    * @var \Magento\Framework\App\Http\Context
    */
    protected $context;
   
    /*
    * @var \Magento\Customer\Model\Visitor
    */
    protected $visitor;
    
    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $session;

    /*
    * @var \Magento\Customer\Model\Visitor
    */
    protected $remoteAddress;
    
    /*
    * @var \Magento\Framework\HTTP\ZendClientFactory
    */
    protected $httpClient;
    
    /*
    * @var \Magento\Framework\Json\Helper\Data
    */
    protected $jsonHelper;

    /**
     * @param \Magento\Framework\Logger\Monolog $loggerInterface
     * @param \Magento\Framework\App\Http\Context $context
     * @param \Magento\Customer\Model\Visitor $visitor
     * @param \Magento\Framework\Session\SessionManagerInterface $session
     * @param \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress
     * @param \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
    */
    public function __construct(
        \Magento\Framework\Logger\Monolog $loggerInterface,
        \Magento\Framework\App\Http\Context $context,
        \Magento\Framework\Session\SessionManagerInterface $session,
        \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
        \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->logger = $loggerInterface;
        $this->context = $context;
        $this->remoteAddress = $remoteAddress;
        $this->httpClient = $httpClientFactory;
        $this->jsonHelper = $jsonHelper;
        $this->session = $session;
    }
    
    
  
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(Observer $observer)
    {
        $this->visitor = $observer->getEvent()->getVisitor();
    
        /* get visitor ip address */
        $visitorIp = $this->remoteAddress->getRemoteAddress();
        
        /* get remote data */
        $remoteData = $this->getServiceResponse($visitorIp);

        if (!empty($remoteData) || ($remoteData !== false)) {
            $this->visitor->setIpAddress($remoteData['ip_address']);
            $this->visitor->setCountry($remoteData['country']);
            $this->session->setVisitorData($this->visitor->getData());
            $this->visitor->save();
        }
    }
    
    /**
     * @param string $ip
     * @return array
     */
    protected function getServiceResponse($ip)
    {
        /** @var \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory */
        $httpClient = $this->httpClient->create();

        $response = [];
        try {
            /* send request to freegeoip.net */
            $httpResponse = $httpClient->setUri(
                self::URL_DATA . $ip
            )->setConfig(
                [
                    'timeout' => self::REQUEST_TIMEOUT
                ]
            )->request(
                'GET'
            );
            
            if ($httpResponse->getStatus() !== 200) {
                $this->logger->warning('Request response did not send a 200 status code.');
                return false;
            };
            

           /* decode response to array */
            $jsonResponse = $this->jsonHelper->jsonDecode($httpResponse->getBody());
            
            $countryName = $jsonResponse['country_name'];
            
            if (!$countryName) {
                $countryName = __('Unknown Country');
            }
 
            return [
                'ip_address' => $jsonResponse['ip'] ,
                'country' => $countryName
            ];
        } catch (\Zend_Http_Client_Exception $e) {
            $this->logger->critical($e);
        }
        return $response;
    }
}
