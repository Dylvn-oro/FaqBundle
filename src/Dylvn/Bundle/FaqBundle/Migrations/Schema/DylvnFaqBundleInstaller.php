<?php

namespace Dylvn\Bundle\FaqBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class DylvnFaqBundleInstaller implements Installation
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createDylvnFaqCategoryTitleTable($schema);
        $this->createDylvnFaqItemQuestionTable($schema);
        $this->createDylvnFaqCategoryDescriptionTable($schema);
        $this->createDylvnFaqItemTable($schema);
        $this->createDylvnFaqCategoryTable($schema);
        $this->createDylvnFaqItemAnswerTable($schema);
        $this->createDylvnFaqCategoryItemTable($schema);

        /** Foreign keys generation **/
        $this->addDylvnFaqCategoryTitleForeignKeys($schema);
        $this->addDylvnFaqItemQuestionForeignKeys($schema);
        $this->addDylvnFaqCategoryDescriptionForeignKeys($schema);
        $this->addDylvnFaqItemForeignKeys($schema);
        $this->addDylvnFaqCategoryForeignKeys($schema);
        $this->addDylvnFaqItemAnswerForeignKeys($schema);
        $this->addDylvnFaqCategoryItemForeignKeys($schema);
    }

    /**
     * Create dylvn_faq_category_title table
     *
     * @param Schema $schema
     */
    protected function createDylvnFaqCategoryTitleTable(Schema $schema)
    {
        $table = $schema->createTable('dylvn_faq_category_title');
        $table->addColumn('category_id', 'integer', []);
        $table->addColumn('localized_value_id', 'integer', []);
        $table->setPrimaryKey(['category_id', 'localized_value_id']);
        $table->addUniqueIndex(['localized_value_id'], 'uniq_79e5486deb576e89');
        $table->addIndex(['category_id'], 'idx_79e5486d12469de2', []);
    }

    /**
     * Create dylvn_faq_item_question table
     *
     * @param Schema $schema
     */
    protected function createDylvnFaqItemQuestionTable(Schema $schema)
    {
        $table = $schema->createTable('dylvn_faq_item_question');
        $table->addColumn('item_id', 'integer', []);
        $table->addColumn('localized_value_id', 'integer', []);
        $table->setPrimaryKey(['item_id', 'localized_value_id']);
        $table->addIndex(['item_id'], 'idx_eab3cb71126f525e', []);
        $table->addUniqueIndex(['localized_value_id'], 'uniq_eab3cb71eb576e89');
    }

    /**
     * Create dylvn_faq_category_description table
     *
     * @param Schema $schema
     */
    protected function createDylvnFaqCategoryDescriptionTable(Schema $schema)
    {
        $table = $schema->createTable('dylvn_faq_category_description');
        $table->addColumn('category_id', 'integer', []);
        $table->addColumn('localized_value_id', 'integer', []);
        $table->addUniqueIndex(['localized_value_id'], 'uniq_4145f714eb576e89');
        $table->addIndex(['category_id'], 'idx_4145f71412469de2', []);
        $table->setPrimaryKey(['category_id', 'localized_value_id']);
    }

    /**
     * Create dylvn_faq_item table
     *
     * @param Schema $schema
     */
    protected function createDylvnFaqItemTable(Schema $schema)
    {
        $table = $schema->createTable('dylvn_faq_item');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('position', 'integer', ['default' => '0']);
        $table->addColumn('enabled', 'boolean', ['default' => '1']);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', []);
        $table->addColumn('serialized_data', 'json', ['notnull' => false]);
        $table->addIndex(['organization_id'], 'idx_5f869ed532c8a3de', []);
        $table->addIndex(['user_owner_id'], 'idx_5f869ed59eb185f9', []);
        $table->setPrimaryKey(['id']);
    }

    /**
     * Create dylvn_faq_category table
     *
     * @param Schema $schema
     */
    protected function createDylvnFaqCategoryTable(Schema $schema)
    {
        $table = $schema->createTable('dylvn_faq_category');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('code', 'string', ['length' => 255]);
        $table->addColumn('position', 'integer', ['default' => '0']);
        $table->addColumn('enabled', 'boolean', ['default' => '1']);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', []);
        $table->addColumn('serialized_data', 'json', ['notnull' => false]);
        $table->addIndex(['organization_id'], 'idx_dc38d4f032c8a3de', []);
        $table->addIndex(['user_owner_id'], 'idx_dc38d4f09eb185f9', []);
        $table->addUniqueIndex(['code'], 'uniq_dc38d4f077153098');
        $table->setPrimaryKey(['id']);
    }

    /**
     * Create dylvn_faq_item_answer table
     *
     * @param Schema $schema
     */
    protected function createDylvnFaqItemAnswerTable(Schema $schema)
    {
        $table = $schema->createTable('dylvn_faq_item_answer');
        $table->addColumn('item_id', 'integer', []);
        $table->addColumn('localized_value_id', 'integer', []);
        $table->addUniqueIndex(['localized_value_id'], 'uniq_50b1acb1eb576e89');
        $table->setPrimaryKey(['item_id', 'localized_value_id']);
        $table->addIndex(['item_id'], 'idx_50b1acb1126f525e', []);
    }

    /**
     * Create dylvn_faq_category_item table
     *
     * @param Schema $schema
     */
    protected function createDylvnFaqCategoryItemTable(Schema $schema)
    {
        $table = $schema->createTable('dylvn_faq_category_item');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('category_id', 'integer', ['notnull' => false]);
        $table->addColumn('item_id', 'integer', ['notnull' => false]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('position', 'integer', ['default' => '0']);
        $table->addColumn('enabled', 'boolean', ['default' => '1']);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', []);
        $table->addIndex(['category_id'], 'idx_a4c915ad12469de2', []);
        $table->addIndex(['user_owner_id'], 'idx_a4c915ad9eb185f9', []);
        $table->addUniqueIndex(['category_id', 'item_id'], 'dylvn_faq_category_item_unq_idx');
        $table->addIndex(['item_id'], 'idx_a4c915ad126f525e', []);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['organization_id'], 'idx_a4c915ad32c8a3de', []);
    }

    /**
     * Add dylvn_faq_category_title foreign keys.
     *
     * @param Schema $schema
     */
    protected function addDylvnFaqCategoryTitleForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('dylvn_faq_category_title');
        $table->addForeignKeyConstraint(
            $schema->getTable('dylvn_faq_category'),
            ['category_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_fallback_localization_val'),
            ['localized_value_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
    }

    /**
     * Add dylvn_faq_item_question foreign keys.
     *
     * @param Schema $schema
     */
    protected function addDylvnFaqItemQuestionForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('dylvn_faq_item_question');
        $table->addForeignKeyConstraint(
            $schema->getTable('dylvn_faq_item'),
            ['item_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_fallback_localization_val'),
            ['localized_value_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
    }

    /**
     * Add dylvn_faq_category_description foreign keys.
     *
     * @param Schema $schema
     */
    protected function addDylvnFaqCategoryDescriptionForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('dylvn_faq_category_description');
        $table->addForeignKeyConstraint(
            $schema->getTable('dylvn_faq_category'),
            ['category_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_fallback_localization_val'),
            ['localized_value_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
    }

    /**
     * Add dylvn_faq_item foreign keys.
     *
     * @param Schema $schema
     */
    protected function addDylvnFaqItemForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('dylvn_faq_item');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_owner_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
    }

    /**
     * Add dylvn_faq_category foreign keys.
     *
     * @param Schema $schema
     */
    protected function addDylvnFaqCategoryForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('dylvn_faq_category');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_owner_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
    }

    /**
     * Add dylvn_faq_item_answer foreign keys.
     *
     * @param Schema $schema
     */
    protected function addDylvnFaqItemAnswerForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('dylvn_faq_item_answer');
        $table->addForeignKeyConstraint(
            $schema->getTable('dylvn_faq_item'),
            ['item_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_fallback_localization_val'),
            ['localized_value_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
    }

    /**
     * Add dylvn_faq_category_item foreign keys.
     *
     * @param Schema $schema
     */
    protected function addDylvnFaqCategoryItemForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('dylvn_faq_category_item');
        $table->addForeignKeyConstraint(
            $schema->getTable('dylvn_faq_category'),
            ['category_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('dylvn_faq_item'),
            ['item_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_owner_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
    }
}
