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

interface VendorInterface
{
    const VENDOR_NAME = 'vendor_name';
    const VENDOR_ID = 'vendor_id';


    /**
     * Get vendor_id
     * @return string|null
     */
    
    public function getVendorId();

    /**
     * Set vendor_id
     * @param string $vendorId
     * @return Training4\Vendor\Api\Data\VendorInterface
     */
    
    public function setVendorId($vendorId);

    /**
     * Get vendor_name
     * @return string|null
     */
    
    public function getVendorName();

    /**
     * Set vendor_name
     * @param string $vendor_name
     * @return Training4\Vendor\Api\Data\VendorInterface
     */
    
    public function setVendorName($vendor_name);
}
