<?php
/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training5
 * @package  Training5_VendorApi
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */
 
namespace Training5\VendorApi\Api;

interface VendorApiInterface
{

    /**
     * save vendor data
     *
     * @api
     * @param string $vendorName.
     * @return string.
     */
    
    public function save($vendorName);
    
    
    /**
     * load vendor data
     *
     * @api
     * @param int $vendorId.
     * @return vendor.
     */
    
    public function load($vendorId);

    /**
     * get list vendors data
     *
     * @api
     * @return Vendor.
     */
    public function getList();
    
    /**
     * get list vendors data
     *
     * @api
     * @param  int $vendorId.
     * @return string test string.
     */
    public function getAssociatedProductIds($vendorId);
}
