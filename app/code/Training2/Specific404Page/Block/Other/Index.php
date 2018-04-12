<?php

/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training2
 * @package  Training2_Specific404Page
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */

namespace Training2\Specific404Page\Block\Other;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * Get Not Found Message
     *
     * @return string
     */
    public function getNotFoundMessage()
    {
        return __('The page you are looking for was not found.');
    }
}
