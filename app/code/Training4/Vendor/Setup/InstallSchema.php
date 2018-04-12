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

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;

class InstallSchema implements InstallSchemaInterface
{

     /**
     * {@inheritdoc}
     * @SuppressWarnings(Generic.CodeAnalysis.UnusedFunctionParameter)
     */
     // @codingStandardsIgnoreStart
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
    // @codingStandardsIgnoreEnd
    
        $installer = $setup;
        $installer->startSetup();

        $tableTraining4Vendor = $setup->getConnection()->newTable($setup->getTable('training4_vendor'));

        
        $tableTraining4Vendor->addColumn(
            'vendor_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            array('identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true, ),
            'Entity ID'
        );
        
        $tableTraining4Vendor->addColumn(
            'vendor_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Vendor Name'
        );

        $setup->getConnection()->createTable($tableTraining4Vendor);

        $setup->endSetup();
    }
}
