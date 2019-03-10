<?php

use yii\db\Migration;

/**
 * Handles adding trainee_date to table `{{%employee}}`.
 */
class m190227_063909_add_trainee_date_column_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%employee}}', 'trainee_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%employee}}', 'trainee_date');
    }
}
