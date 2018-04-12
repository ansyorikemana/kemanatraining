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

namespace Training3\OrderInfo\Plugin\Training2\OrderController\Controller;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;

class Index
{

    /**
     * @var Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @var Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;
    
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @param CaptchaHelper $helper
     * @param SessionManagerInterface $sessionManager
     * @param JsonFactory $resultJsonFactory
     * @param array $formIds
     * @param \Magento\Framework\Serialize\Serializer\Json|null $serializer
     * @throws \RuntimeException
     */

    public function __construct(
        Registry $registry,
        UrlInterface $url,
        ResultFactory $resultFactory,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->coreRegistry = $registry;
        $this->url = $url;
        $this->resultFactory = $resultFactory;
        $this->request = $request;
    }


    /**
     * @param \Training2\OrderController\Controller\Format\Json $subject
     * @param \Closure $proceed
     * @return $this
     */
    public function aroundExecute(
        \Training2\OrderController\Controller\Index\Index $subject,
        $proceed
    ) {
        $isJsonFlag = (int)$this->request->getParam('json');
        $orderId = (int)$this->request->getParam('orderID');
        
        $request = $subject->getRequest();
        
        if (!isset($isJsonFlag) || ($isJsonFlag === 0)) :
            $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $result->setUrl($this->url->getUrl('orderinfo').'?orderID='.$orderId);
            return $result;
        endif;
        
        return $proceed();
    }
}
