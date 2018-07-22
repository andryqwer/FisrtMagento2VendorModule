<?php

/**
 * @author Volodymyr Semeniuk <vovasem97@gmail.com>
 * @since 21.07.2018 12:11
 */

namespace Semeniuk\Vendor\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /**
         * Drop table if exists
         */
        $setup->getConnection()->dropTable($setup->getTable('semeniuk_vendor'));

        /**
         * Create table 'semeniuk_vendor'
         */
        $table = $setup->getConnection()
            ->newTable($setup->getTable('semeniuk_vendor'))
            ->addColumn(
                'vendor_id',
                Table::TYPE_INTEGER,
                11,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Vendor ID'
            )
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Vendor Name'
            )
            ->addColumn(
                'description',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Vendor Description'
            )
            ->addColumn(
                'created_date',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Created Date'
            )
            ->addColumn(
                'logo_path',
                Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Logo Path'
            )
            ->setComment('Vendor Table');
        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}