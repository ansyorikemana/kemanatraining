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

namespace Training4\Vendor\Block\Product;

use Magento\Framework\View\Element\Template;

class Vendor extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var Training4\Vendor\Model\ResourceModel\Vendor\CollectionFactory
     */
    protected $vendorCollectionFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context               $context
     * @param \Magento\Framework\Registry                                    $coreRegistry
     * @param \Training4\Vendor\Model\ResourceModel\Vendor\CollectionFactory $vendorCollectionFactory
     * @param array                                                          $data
     */
    public function __construct(
        Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Training4\Vendor\Model\ResourceModel\Vendor\CollectionFactory $vendorCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->coreRegistry = $coreRegistry;
        $this->vendorCollectionFactory = $vendorCollectionFactory;
    }

    /**
     * Get all vendors
     *
     * @return array
     */
    public function getAllVendorsData()
    {
        $list = array();
        $vendors = $this->vendorCollectionFactory->create();
        foreach ($vendors as $vendor) {
            if ($vendor->getId()) {
                $list[$vendor->getId()] = $vendor->getVendorName();
            }
        }
        
        return $list;
    }

    /**
     * Get products inside vendor
     *
     * @return array
     */
    public function getProductVendors()
    {
        $vendors = [];
        $product_id = $this->coreRegistry->registry('current_product')->getId();
        
        $collection = $this->vendorCollectionFactory->create()->getVendorsByProductId($product_id);
        
        return $collection;
    }
}
