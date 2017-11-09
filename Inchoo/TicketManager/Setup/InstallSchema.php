<?php
/**
 * Created by PhpStorm.
 * User: antun
 * Date: 11/3/17
 * Time: 3:02 PM
 */

namespace Inchoo\TicketManager\Setup;


use Inchoo\TicketManager\Api\Data\TicketInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /**
         * Create table 'inchoo_ticket'
         */
        $table = $setup->getConnection()->newTable(
            $setup->getTable('inchoo_ticket')
        )->addColumn(
            TicketInterface::TICKET_ID,
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Ticket Id'
        )->addColumn(
            TicketInterface::SUBJECT,
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Ticket Subject'
        )->addColumn(
            TicketInterface::MESSAGE,
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => false],
            'Ticket message'
        )->addColumn(
            TicketInterface::CUSTOMER_ID,
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true],
            'Customer'
        )->addColumn(
            TicketInterface::IS_CLOSED,
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            [
                'nullable' => false,
                'default' => false
            ],
            'Is closed'
        )->addColumn(
            TicketInterface::WEBSITE_ID,
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true],
            'Website'
        )->addColumn(
            TicketInterface::CREATED_AT,
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Created at'
        )->addColumn(
            TicketInterface::UPDATED_AT,
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
            ],
            'Updated at'
        )->addForeignKey(
            $setup->getFkName('inchoo_ticket', 'customer_id', $setup->getTable('customer_entity'), 'entity_id'),
            'customer_id',
            $setup->getTable('customer_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_SET_NULL
        )->addForeignKey(
            $setup->getFkName('inchoo_ticket', 'website_id', 'store_website', 'website_id'),
            'website_id',
            $setup->getTable('store_website'),
            'website_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_SET_NULL
        )->setComment(
            'Ticket table'
        );

        $setup->getConnection()->createTable($table);

        /**
         * Create table 'inchoo_ticket_reply'
         */
        $table = $setup->getConnection()->newTable(
            $setup->getTable('inchoo_ticket_reply')
        )->addColumn(
            'ticket_reply_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Reply Id'
        )->addColumn(
            'message',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => false],
            'Reply message'
        )->addColumn(
            'admin_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true],
            'Website'
        )->addColumn(
            'ticket_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true],
            'Website'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Created at'
        )->addColumn(
            'updated_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
            ],
            'Updated at'
        )->addForeignKey(
            $setup->getFkName('inchoo_ticket_reply', 'ticket_id', $setup->getTable('inchoo_ticket'), 'ticket_id'),
            'ticket_id',
            $setup->getTable('inchoo_ticket'),
            'ticket_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $setup->getFkName('inchoo_ticket_reply', 'admin_id', $setup->getTable('admin_user'), 'user_id'),
            'admin_id',
            $setup->getTable('admin_user'),
            'user_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Ticket Reply table'
        );

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}