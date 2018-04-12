<?php
/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training4
 * @package  Training4_Warranty
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */

namespace Training4\Warranty\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class InstallData implements InstallDataInterface
{
    protected $eavSetupFactory;

    /**
      * {@inheritdoc}
     * @SuppressWarnings(Generic.CodeAnalysis.UnusedFunctionParameter)
     */
    // @codingStandardsIgnoreStart
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
    // @codingStandardsIgnoreEnd
    
        //Your install script

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'warranty',
            [
                'type' => 'varchar',
                'label' => 'Warranty',
                'input' => 'text',
                'global' => 1,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => null,
                'searchable' => true,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'backend' => 'Training4\Warranty\Model\Attribute\Backend\AttributeWarranty',
                'frontend' => 'Training4\Warranty\Model\Attribute\Frontend\AttributeWarranty',
                'apply_to' => '',
                'system' => 0,
                'group' => 'General',
                 'is_html_allowed_on_front' => true
            ]
        );
    }

    /**
     * Constructor
     *
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
}
