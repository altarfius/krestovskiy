<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%division}}`.
 */
class m190224_043037_create_division_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%division}}', [
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
        $this->dropTable('{{%division}}');
    }
}
