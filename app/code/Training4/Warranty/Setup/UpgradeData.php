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

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['install' => $setup]);
        if ($context->getVersion()
            && version_compare($context->getVersion(), '1.0.1') < 0
        ) {
            $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
            $attributeSetId = $eavSetup
                ->getAttributeSetId($entityTypeId, 'Gear');
            if (!$attributeSetId) {
                $attributeSet = $eavSetup->addAttributeSet($entityTypeId, 'Gear');
                $attributeSetId = $attributeSet->getId();
            }
            $groupId = $eavSetup->
                       getAttributeGroupId(\Magento\Catalog\Model\Product::ENTITY, $attributeSetId, 'Product Details');
            $eavSetup->addAttributeToGroup(
                \Magento\Catalog\Model\Product::ENTITY,
                $attributeSetId,
                $groupId,
                'warranty'
            );
        }
        $setup->endSetup();
    }
}
