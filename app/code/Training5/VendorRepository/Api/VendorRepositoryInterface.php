<?php
/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training5
 * @package  Training5_VendorRepository
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */
 
namespace Training5\VendorRepository\Api;

interface VendorRepositoryInterface
{

    /**
     * save vendor data
     *
     * @api
     * @param int $vendor.
     * @return string test string.
     */
    
    public function save(
        \Training4\Vendor\Api\Data\VendorInterface $vendor
    );
    
    
    /**
     * load vendor data
     *
     * @api
     * @param int $vendorId.
     * @return string test string.
     */
    
    public function load($vendorId);

    /**
     * get list vendors data
     *
     * @api
     * @param  $searchCriteria.
     * @return string test string.
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );
    
    /**
     * get list vendors data
     *
     * @api
     * @param  int $vendorId.
     * @return string test string.
     */
    public function getAssociatedProductIds($vendorId);
}
