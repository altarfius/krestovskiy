<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 * Has foreign keys to the tables:
 *
 * - `category_type`
 */
class m190126_103457_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'category_type_id' => $this->integer()->notNull(),
            'active' => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ]);

        // creates index for column `category_type_id`
        $this->createIndex(
            'idx-category-category_type_id',
            'category',
            'category_type_id'
        );

        // add foreign key for table `category_type`
        $this->addForeignKey(
            'fk-category-category_type_id',
            'category',
            'category_type_id',
            'category_type',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `category_type`
        $this->dropForeignKey(
            'fk-category-category_type_id',
            'category'
        );

        // drops index for column `category_type_id`
        $this->dropIndex(
            'idx-category-category_type_id',
            'category'
        );

        $this->dropTable('category');
    }
}
