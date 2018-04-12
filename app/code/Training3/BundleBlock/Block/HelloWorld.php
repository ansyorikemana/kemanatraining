<?php

/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training3
 * @package  Training3_BundleBlock
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */

namespace Training3\BundleBlock\Block;

class HelloWorld extends \Magento\Framework\View\Element\Template
{
    /**
     * Get Hello Word Message
     *
     * @return string
     */
    public function getHelloWorldMessage()
    {
        return __('Hello World');
    }
}
