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

namespace Training4\Vendor\Model\ResourceModel\Vendor;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Training4\Vendor\Model\Vendor',
            'Training4\Vendor\Model\ResourceModel\Vendor'
        );
    }
    
    /**
     * @param int $productId
     * @return array
     */
    public function getVendorsByProductId($productId)
    {
        if ($productId) {
            $connection = $this->getConnection();
            $select = $connection->select()
                ->from(
                    array(
                    'link_table'=> $this->getTable('training4_vendorproduct')),
                    ['link_table.product_id']
                )->join(
                    array('vendors' => $this->getMainTable()),
                    'vendors.vendor_id = link_table.vendor_id'
                )->where('link_table.product_id = ?', $productId);
            $result = $connection->fetchAssoc($select);
            return $result;
        }
    }
    
    /**
     * @param int $vendorId
     * @return array
     */
    public function getProductsByVendorId($vendorId)
    {
        if ($vendorId) {
            $connection = $this->getConnection();
            $select = $connection->select()
                ->from(
                    array(
                    'link_table'=> $this->getTable('training4_vendorproduct')),
                    ['link_table.product_id']
                )->join(
                    array('vendors' => $this->getMainTable()),
                    'vendors.vendor_id = link_table.vendor_id'
                )->where('link_table.vendor_id = ?', $vendorId);
            $result = $connection->fetchAssoc($select);
            return $result;
        }
    }
}
