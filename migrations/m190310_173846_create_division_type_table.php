<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%division_type}}`.
 */
class m190310_173846_create_division_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%division_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%division_type}}');
    }
}
