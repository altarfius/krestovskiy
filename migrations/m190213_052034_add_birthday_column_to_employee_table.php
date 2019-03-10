<?php

use yii\db\Migration;

/**
 * Handles adding birthday to table `employee`.
 */
class m190213_052034_add_birthday_column_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%employee}}', 'birthday', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%employee}}', 'birthday');
    }
}
