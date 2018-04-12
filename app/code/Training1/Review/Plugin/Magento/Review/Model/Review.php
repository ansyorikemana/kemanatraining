<?php

/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training1
 * @package  Training1_Review
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */

namespace Training1\Review\Plugin\Magento\Review\Model;

class Review
{
    public function afterValidate(
        \Magento\Review\Model\Review $subject,
        $result
    ) {
        $error = null;
        $checkDash = strpos($subject->getNickname(), '-');
            
        if ($checkDash !== false) {
            $error =  __('Dashes (-) on nickname is not allowed');
        }
            
        if ($error && is_bool($result)) {
            return [
                $error
            ];
        } elseif ($error && !is_bool($result)) {
            $result[] = $error;
        }
            
        return $result;
    }
}
