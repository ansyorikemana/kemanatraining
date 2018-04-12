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

use Training4\Vendor\Model\Vendor;
use Training4\Vendor\Model\VendorFactory;
use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Vendor factory
     *
     * @var VendorFactory
     */
    protected $vendorFactory;

    /**
     * Init
     *
     * @param VendorFactory $vendorFactory
     */
    public function __construct(VendorFactory $vendorFactory)
    {
        $this->vendorFactory = $vendorFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(Generic.CodeAnalysis.UnusedFunctionParameter)
     */
     // @codingStandardsIgnoreStart
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $vendors = [
            [
                'vendor_name' => 'Microsoft',
            ],
            [
                'vendor_name' => 'Apple',
            ],
            [
                'vendor_name' => 'Google',
            ],
            [
                'vendor_name' => 'Oracle',
            ],
        ];

        /**
         * Insert default vendors
         */
        foreach ($vendors as $data) {
            $this->insertNewVendor($data);
        }

        $setup->endSetup();
    }
    
    /**
     * Insert new vendor
     * @param array $data
     */

    public function insertNewVendor(array $data)
    {
        $this->vendorFactory
                 ->create()
                 ->setData($data)
                 ->save();
    }
}
