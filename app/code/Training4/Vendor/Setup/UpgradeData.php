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

namespace Training4\Vendor\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    /**
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     *
     * @var \Training4\Vendor\Model\ResourceModel\Vendor\CollectionFactory
     */
    protected $vendorCollectionFactory;
    

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Training4\Vendor\Model\ResourceModel\Vendor\CollectionFactory $vendorCollectionFactory
    ) {
        $this->productCollectionFactory = $collectionFactory;
        $this->vendorCollectionFactory = $vendorCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.6', '<')) {
            $vendorCollection = $this->vendorCollectionFactory->create();
            
            $minVendorId = 0;
            $maxVendorId = 0;
            $idx = 0;
            foreach ($vendorCollection as $vendor) {
                if ($idx === 0) {
                    $minVendorId = $vendor->getId();
                }
                $maxVendorId = $vendor->getId();
                
                $idx++;
            }
            
            $collection = $this->productCollectionFactory->create();

            foreach ($collection as $product) {
                $bind = [
                    'vendor_id' => rand($minVendorId, $maxVendorId),
                    'product_id' => $product->getId(),
                ];
                $setup->getConnection()->insert('training4_vendorproduct', $bind);
            }
        }

        $setup->endSetup();
    }
}
