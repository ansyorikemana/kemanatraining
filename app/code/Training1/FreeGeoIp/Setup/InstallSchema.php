<?php

/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training1
 * @package  Training1_FreeGeoIp
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */

namespace Training1\FreeGeoIp\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Customer Visitor table in Database
     */
    const TABLE_CUSTOMER_VISITOR = 'customer_visitor';

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $installer->getConnection()->addColumn(
            $installer->getTable(self::TABLE_CUSTOMER_VISITOR),
            'ip_address',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'unsigned' => true,
                'nullable' => true,
                'default' => null,
                'comment' => 'Visitor Ip Address'
            ]
        );
        
        $installer->getConnection()->addColumn(
            $installer->getTable(self::TABLE_CUSTOMER_VISITOR),
            'country',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'unsigned' => true,
                'nullable' => true,
                'default' => null,
                'comment' => 'Visitor Country'
            ]
        );

        $installer->endSetup();
    }
}
