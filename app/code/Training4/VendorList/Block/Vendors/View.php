<?php
/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training4
 * @package  Training4_VendorList
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */

namespace Training4\VendorList\Block\Vendors;

use Magento\Framework\View\Element\Template;

class View extends \Magento\Framework\View\Element\Template
{
    protected $coreRegistry;
    protected $vendorCollectionFactory;
    protected $vendorFactory;
    protected $productFactory;


    public function __construct(
        Template\Context $context,
        \Training4\Vendor\Model\ResourceModel\Vendor\CollectionFactory $vendorCollectionFactory,
        \Training4\Vendor\Model\VendorFactory $vendorFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);


        $this->vendorCollectionFactory = $vendorCollectionFactory;
        $this->vendorFactory = $vendorFactory;
        $this->productFactory = $productFactory;
    }
    
    
    public function getVendorData()
    {
        $vendorId = (int) $this->getRequest()->getParam('vendor_id');
        
        $data = $this->vendorFactory->create()->load($vendorId);
        
        return $data;
    }
    
    public function getProductData($productId)
    {
        return $this->productFactory->create()->load($productId);
    }
    
    
    public function getProductVendors()
    {
        $vendorId = (int) $this->getRequest()->getParam('vendor_id');
        
        $collection = $this->vendorCollectionFactory->create()->getProductsByVendorId($vendorId);
        
        return $collection;
    }
}
