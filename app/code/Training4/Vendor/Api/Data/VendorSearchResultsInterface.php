<?php
/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training4
 * @package  Training4_Vendor
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */

namespace Training4\Vendor\Api\Data;

interface VendorSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Vendor list.
     * @return \Training4\Vendor\Api\Data\VendorInterface[]
     */
    
    public function getItems();

    /**
     * Set vendor_name list.
     * @param \Training4\Vendor\Api\Data\VendorInterface[] $items
     * @return $this
     */
    
    public function setItems(array $items);
}
