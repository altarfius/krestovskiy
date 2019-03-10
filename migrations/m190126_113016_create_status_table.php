<?php

use yii\db\Migration;

/**
 * Handles the creation of table `status`.
 */
class m190126_113016_create_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'stage' => $this->integer(),
            'next_stage' => $this->integer(),
            'style' => $this->string(),
            'active' => $this->tinyInteger(1)->notNull()->defaultValue(1)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status}}');
    }
}
