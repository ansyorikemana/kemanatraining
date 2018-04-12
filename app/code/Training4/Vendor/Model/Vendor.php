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

namespace Training4\Vendor\Model;

use Training4\Vendor\Api\Data\VendorInterface;

class Vendor extends \Magento\Framework\Model\AbstractModel implements VendorInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Training4\Vendor\Model\ResourceModel\Vendor');
    }

    /**
     * Get vendor_id
     * @return string
     */
    public function getVendorId()
    {
        return $this->getData(self::VENDOR_ID);
    }

    /**
     * Set vendor_id
     * @param string $vendorId
     * @return Training4\Vendor\Api\Data\VendorInterface
     */
    public function setVendorId($vendorId)
    {
        return $this->setData(self::VENDOR_ID, $vendorId);
    }

    /**
     * Get vendor_name
     * @return string
     */
    public function getVendorName()
    {
        return $this->getData(self::VENDOR_NAME);
    }

    /**
     * Set vendor_name
     * @param string $vendor_name
     * @return Training4\Vendor\Api\Data\VendorInterface
     */
    public function setVendorName($vendor_name)
    {
        return $this->setData(self::VENDOR_NAME, $vendor_name);
    }
}
