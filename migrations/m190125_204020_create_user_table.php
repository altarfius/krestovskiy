<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m190125_204020_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull(),
            'surname' => $this->string(),
            'name' => $this->string(),
            'hash' => $this->char(40)->notNull(),
            'create_time' => $this->timestamp()->defaultValue(new Expression('CURRENT_TIMESTAMP'))
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
