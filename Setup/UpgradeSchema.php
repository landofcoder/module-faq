<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_FAQ
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\Faq\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.7', '<')) {
            $tableItems = $installer->getTable('lof_faq_category');

            $installer->getConnection()->addColumn(
                $tableItems,
                'parent_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Parent Id'
                ]
            );

            $installer->getConnection()->addColumn(
                $tableItems,
                'title_size',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Size'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'title_color',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Color'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'title_color_active',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Color Active'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'title_bg',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Background'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'title_bg_active',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Background Active'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'border_width',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Border Width'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'title_border_color',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Border Color'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'title_border_radius',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Border Radius'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'body_size',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Body Size'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'body_color',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Body Color'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'body_bg',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Body Background'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'question_margin',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Question Margin'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'question_icon',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Question Icon'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'question_active_icon',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Question Active Icon'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'animation_class',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Animation Class'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'animation_speed',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Animation Speed'
                ]
            );
            $installer->getConnection()->addColumn(
                $tableItems,
                'cat_icon',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'category Icon'
                ]
            );


            $postTable = $installer->getTable('lof_faq_question');
            $installer->getConnection()->addColumn(
                $postTable,
                'tag',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Tags'
                ]
            );

            $installer->getConnection()->addColumn(
                $postTable,
                'like',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Like'
                ]
            );

            $installer->getConnection()->addColumn(
                $postTable,
                'disklike',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Disk Like'
                ]
            );

            $installer->getConnection()->addColumn(
                $postTable,
                'title_size',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Size'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'title_color',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Color'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'title_color_active',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Color Active'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'title_bg',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Background'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'title_bg_active',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Background Active'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'border_width',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Border Width'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'title_border_color',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Border Color'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'title_border_radius',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Title Border Radius'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'body_size',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Body Size'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'body_color',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Body Color'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'body_bg',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Body Background'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'question_margin',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Question Margin'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'question_icon',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Question Icon'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'question_active_icon',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Question Active Icon'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'animation_class',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Animation Class'
                ]
            );
            $installer->getConnection()->addColumn(
                $postTable,
                'animation_speed',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Animation Speed'
                ]
            );


            /**
             * Create table 'lof_faq_question_tag'
             */
            $installer = $setup;
            $installer->startSetup();
            $setup->getConnection()->dropTable($setup->getTable('lof_faq_question_tag'));
            $table = $installer->getConnection()->newTable(
                $installer->getTable('lof_faq_question_tag')
            )->addColumn(
                'tag_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Tag ID'
            )->addColumn(
                'question_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Question ID'
            )->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Name'
            )->addColumn(
                'alias',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Alias'
            )->addForeignKey(
                $installer->getFkName('lof_faq_question_tag', 'question_id', 'lof_faq_question', 'question_id'),
                'question_id',
                $installer->getTable('lof_faq_question'),
                'question_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->setComment(
                'Question Tag Table'
            );
            $installer->getConnection()->createTable($table);


            /**
             * Create table 'lof_faq_question_vote'
             */
            $table = $installer->getConnection()->newTable(
                $installer->getTable('lof_faq_question_vote')
            )->addColumn(
                'vote_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Vote Id'
            )->addColumn(
                'like',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => false],
                'Like'
            )->addColumn(
                'disklike',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => false],
                'Disk Like'
            )->addColumn(
                'customer_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Email'
            )->addColumn(
                'customer_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Name'
            )->addColumn(
                'ip',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer IP'
            )->addColumn(
                'question_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Question Id'
            )->addIndex(
                $installer->getIdxName('lof_faq_question_vote', ['vote_id', 'question_id']),
                ['vote_id']
            )->addForeignKey(
                $installer->getFkName('lof_faq_question_vote', 'question_id', 'lof_faq_question', 'question_id'),
                'question_id',
                $installer->getTable('lof_faq_question'),
                'question_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->setComment(
                'Vote'
            );
            $installer->getConnection()->createTable($table);
            $installer->endSetup();


            /**
             * Create table 'lof_faq_question_relatedquestion'
             */
            $installer = $setup;
            $installer->startSetup();
            $setup->getConnection()->dropTable($setup->getTable('lof_faq_question_relatedquestion'));
            $table = $installer->getConnection()->newTable(
                $installer->getTable('lof_faq_question_relatedquestion')
            )->addColumn(
                'question_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false, 'primary' => true],
                'Question ID'
            )->addColumn(
                'relatedquestion_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'primary' => true],
                'Related Question ID'
            )->addColumn(
                'position',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                255,
                ['nullable' => false],
                'Position'
            )->addForeignKey(
                $installer->getFkName('lof_faq_question_relatedquestion', 'question_id', 'lof_faq_question', 'question_id'),
                'question_id',
                $installer->getTable('lof_faq_question'),
                'question_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->setComment(
                'Question Tag Table'
            );
            $installer->getConnection()->createTable($table);
        }

        if (version_compare($context->getVersion(), '1.0.8', '<')) {
            $question_table = $installer->getTable('lof_faq_question');
            $installer->getConnection()->addColumn(
                $question_table,
                'question_url',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Question URL key'
                ]
            );

            $installer->getConnection()->addIndex(
                $installer->getTable('lof_faq_category'),
                $setup->getIdxName(
                    $installer->getTable('lof_faq_category'),
                    ['identifier'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['identifier'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            );

        }
    }
}
