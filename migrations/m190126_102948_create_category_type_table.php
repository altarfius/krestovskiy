<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category_type`.
 */
class m190126_102948_create_category_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'active' => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category_type');
    }
}
